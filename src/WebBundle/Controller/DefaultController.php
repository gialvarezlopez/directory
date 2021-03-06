<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Contactus;
use AppBundle\Entity\UserViews;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include GeoIp2 Classes
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class DefaultController extends Controller
{

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        /*
        *   Obtain all profiles data
        */
        $_state     =   $request->query->get('state');
        $_city      =   $request->query->get('city');
        $_speciality=   $request->query->get('speciality');
        $_country   =   $request->query->get('country');
        $_filter    ='';
        $zoom       = 0;
        $stado_lat_lng=0;
        $busqueda   = array();
        $citis      = 0;
        $countries  = 0;
        $estados_d  = 0;
        $mapaZoom   = 0;
        $category   = 0;

        $busqueda['_STATE'] =0;
        $busqueda['_CITY']  =0;
        $busqueda['_SPECI'] =0;
        $busqueda['_COUNTRY']=0;

        //$sBusqueda = $request->query->get('b');
        $sUsuarios = '';

        if (( $_state!="" ) or ( $_city!="" ) or ( $_speciality!="" ) or ( $_country!="" )) {
            $_SESSION['_STATE']     = $_state;
            $_SESSION['_CITY']      = $_city;
            $_SESSION['_SPECI']     = $_speciality;
            $_SESSION['_COUNTRY']   = $_country;

            $busqueda['_STATE']     = $_SESSION['_STATE'];
            $busqueda['_CITY']      = $_SESSION['_CITY'];
            $busqueda['_SPECI']     = $_SESSION['_SPECI'];
            $busqueda['_COUNTRY']   = $_SESSION['_COUNTRY'];

            if($_state){
                $_filter .= ' and s.sta_id='.$_state;

                if ($_city){
                    $_filter .= ' and ci.cit_id ='.$_city;
                }
            }
            if ($_speciality != 0){
                $_filter .= ' and ues.sp_id ='.$_speciality;
            }
            if ($_country != 0){
                    $sql_estado = "select * from country where cou_id = ". $_country;
                    $statement  = $em->getConnection()->prepare($sql_estado);
                                    $statement->execute();
                    $estados_d= $statement->fetchAll();

                    $_filter .= ' and cou.cou_id ='. $_country ;

                    $mapaZoom = 4;
            }

            if(isset($_state) and $_state!=""){

                $sql_estado = "select * from state where sta_id = ".$_state;
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $estados_d = $statement->fetchAll();

                $mapaZoom = 7;
            }

            // Obteniendo todas las cities del estado en session
            if(isset($_SESSION['_CITY']) and $_city!="" ){
                $sql_estado = "select * from city where sta_id = ". $_SESSION['_STATE'];
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $citis = $statement->fetchAll();

            }
            if(isset($_country) && is_numeric($_country)){
                $sql_estado = "select * from country where cou_id = ". $_SESSION['_COUNTRY'];
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $countries = $statement->fetchAll();
            }
            if(isset($_GET['category']) and $_GET['category']!='' and $_GET['category']!=0 ){
                $_filter .= ' and ca.cat_id ='. $_GET['category'] ;
            }

            $zoom = 1;

        }else{

            $sql_estado = "select * from state where sta_id = 1";
            $statement  = $em->getConnection()->prepare($sql_estado);
                            $statement->execute();
            $estados_d  = $statement->fetchAll();

            $zoom = 0;
            $mapaZoom = 4;
        }



        $state 	    = $em->getRepository('AppBundle:State')->findBy( array('cou' => $_country) );
        $speciality = $em->getRepository('AppBundle:Speciality')->findAll();
        $country    = $em->getRepository('AppBundle:Country')->findAll();
        $category    = $em->getRepository('AppBundle:Category')->findAll();

         $RAW_QUERY	= "select  u.usr_id, md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code,
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1,ca.cat_icon,ca.cat_id,ci.ci_company,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
			LEFT JOIN state as s on s.sta_id = c.sta_id

			LEFT JOIN user_has_speciality AS ues ON ues.usr_id = u.usr_id
            LEFT JOIN speciality as e on e.sp_id = ues.sp_id
            LEFT JOIN category AS ca ON ca.cat_id = ci.cat_id
            LEFT JOIN country as cou ON cou.cou_id = u.cou_id
            WHERE u.usr_active = 1 AND ci.ci_lat != '' AND ( SELECT pay_deadline FROM payer WHERE pay_deadline >= CURDATE() AND usr_id = u.usr_id ORDER BY pay_deadline DESC LIMIT 1 ) >= CURDATE() $_filter
            group by u.usr_id ";
        $statement  = $em->getConnection()->prepare($RAW_QUERY);
        			  $statement->execute();
        $medic    	= $statement->fetchAll();


        /**
        * @VAR $paginator \Knp\Component\Pager\Paginator
        */
        $paginator = $this->get('knp_paginator');
                        $pagination = $paginator->paginate(
                                $medic,
                                $request->query->getInt('page', 1),
                                9);


        $geo = $this->geoIP();
        if( is_object($geo)  && $geo != "" )
        {
            $isoCode = strtoupper($geo->country->isoCode);
        }
        else
        {
            $isoCode = "US";
        }

        $cur = $this->currentLatLngUser( $isoCode );
        $currentUserLat = $cur["lat"];
        $currentUserLng = $cur["lng"];

        return $this->render('web/default/index.html.twig', array(
                'country'=> $country,
                'state'=> $state ,
                'medic' => $pagination,
                'speciality' => $speciality ,
                'zoom' => $zoom ,
                'stateDatos' => $stado_lat_lng  ,
                'filters' => $busqueda ,
                'cities'=>$citis ,
                'countries' => $countries ,
                'estados_d' => $estados_d ,
                'mapaZoom'=> $mapaZoom ,
                'category'=>$category,
                "currentUserLat" => $currentUserLat,
                "currentUserLng" => $currentUserLng
            )
        );
    }

    public function geoIP()
    {
        //https://ourcodeworld.com/articles/read/693/how-to-detect-the-city-country-and-locale-from-a-visitor-s-ip-using-the-free-geolite-database-in-symfony-3

        //IS CODE
        //http://kirste.userpage.fu-berlin.de/diverse/doc/ISO_3166.html

        // Declare the path to the GeoLite2-City.mmdb file (database)
        $GeoLiteDatabasePath = $this->get('kernel')->getRootDir() . '/../web/GeoLite2-City/GeoLite2-City.mmdb';

        // Create an instance of the Reader of GeoIp2 and provide as first argument
        // the path to the database file
        $reader = new Reader($GeoLiteDatabasePath);

        try{
            // if you are in the production environment you can retrieve the
            // user's IP with $request->getClientIp()
            // Note that in a development environment 127.0.0.1 will
            // throw the AddressNotFoundException

            //var_dump($reader);
            // In this example, use a fixed IP address in Minnesota

            $ip = $_SERVER['REMOTE_ADDR'];
            $record = $reader->city($ip);

        } catch (AddressNotFoundException $ex) {
            // Couldn't retrieve geo information from the given IP
            //return new Response("It wasn't possible to retrieve information about the providen IP");
            return false;
        }

        //return new JsonResponse($record);
        return $record;
    }

    public function currentLatLngUser( $isoCode )
    {
        $em  = $this->getDoctrine()->getManager();

        $currentUserLat = "38.46581101942668";
        $currentUserLng = "-97.67327016328125";
        if( $isoCode != "" )
        {
            $result  =  $em->getRepository('AppBundle:Country')->findOneBy( array('isoCode' => $isoCode ) );
            if( $result )
            {
                $currentUserLat = $result->getStaLat();
                $currentUserLng =  $result->getStaLng();
            }
        }

        return array("lat"=>$currentUserLat,"lng"=>$currentUserLng);
    }

    public function showProfileAction( Request $request){

        /*
        *   Obtain profile detail by user
        */
        $id_profile = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        //$id_profile = 0;

        if( is_numeric($id_profile) )
        {

            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array( "usrId"=> $id_profile) );

            if(!$oUser)
            {
                throw new NotFoundHttpException("Record not found");
            }

            $showContactForm = $oUser->getUsrNotificationContactForm();
            //Obtain Social Network
            $oListMySocialNetworks = $em->getRepository('AppBundle:UserHasSocialNetwork')->findBy( array("usr"=>$id_profile, "usnActive"=>1),array('sn' => 'ASC') );
        }
        else
        {
            throw new NotFoundHttpException("Page not found");
        }

        $RAW_QUERY  = "select  u.usr_id, md.md_first_name,  ci.ci_company,ci.ci_schedule,md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, md.md_profile_description, ca.cat_id,ci.ci_company,md.md_academic_training,md.md_professional_experience,md.md_courses_seminars,md.md_aditional_information,
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1, ci.ci_phone2,u.usr_email,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
            LEFT JOIN state as s on s.sta_id = c.sta_id
            LEFT JOIN speciality as e on e.usr_id = u.usr_id
            LEFT JOIN category AS ca ON ca.cat_id = ci.cat_id
            WHERE u.usr_active = 1 AND u.usr_id = ". $id_profile . " AND ( SELECT pay_deadline FROM payer WHERE pay_deadline >= CURDATE() AND usr_id = u.usr_id ORDER BY pay_deadline DESC LIMIT 1 ) >= CURDATE()
            group by u.usr_id";

        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                      $statement->execute();
        $profile      = $statement->fetchAll();

        if( count($profile) == 0 )
        {
            throw new NotFoundHttpException("Profile is not available");
        }

        //Obtain gallery

        $RAW_GALLERY    = "select * from gallery where usr_id = ".$id_profile;
        $statement      = $em->getConnection()->prepare($RAW_GALLERY);
                          $statement->execute();
        $gallery        = $statement->fetchAll();


        /*
            $RAW_Social     = "select * from user_has_social_network usn left join social_network as sn on
                                usn.sn_id = sn.sn_id where usr_id =".$id_profile;
            $statement      = $em->getConnection()->prepare($RAW_Social);
                            $statement->execute();
            $social_network = $statement->fetchAll();
        */

        $horaDias = array();
        $hoy = "";
        if($profile[0]['ci_schedule']!=""){
            $arr = unserialize($profile[0]['ci_schedule']);

            $num = 1;

            $horaDias = array();
            $dias = array(1 => "Mon", 2 => "Tus", 3 => "Wed", 4 => "Thr", 5 => "Fri", 6 => "Sat", 7 => "Sun");
            $hoy = $dias[date("N")];

            foreach ($arr as $key => $value)
            {
                if ( count($value) > 0 )
                {
                    $hd = "";
                    $cadena = $this->rangos($value);
                    $hd .= $cadena;
                    $horaDias[$key] = $hd;
                }
                $num++;
            }
            //var_dump($horaDias);
        }

        $this->ViewsProfiles( $request , $id_profile );

        $link = $this->generateUrl(
            'web_show_profile', [
                'id'=>$id_profile
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        //echo $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        return $this->render('web/default/showProfile.html.twig',
             array(
                 'profile' => $profile ,
                 "horario" => $horaDias,
                 "hoy" => $hoy,
                 'gallery' => $gallery ,
                 //'social_network' => $social_network,
                 "oListMySocialNetworks"=>$oListMySocialNetworks,
                 "showContactForm" =>$showContactForm,
                 "url"=>$link,
                )
            );
    }

    public function showFullProfileAction( Request $request ){
        return $this->render('web/default/showProfile.html.twig');
    }

    public function getStateByCountryAction( Request $request ){

        $em     = $this->getDoctrine()->getManager();
        //$state    = $em->getRepository('AppBundle:City')->findby( array('sta' => $_POST['id']) );

        $RAW_QUERY  = "select * from state where state.cou_id =". $_POST['id'];

        $statement  = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $state      = $statement->fetchAll();

        $response = new Response(json_encode($state));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getCitiesByStateAction( Request $request ){

    	$em 	= $this->getDoctrine()->getManager();
        //$state 	= $em->getRepository('AppBundle:City')->findby( array('sta' => $_POST['id']) );

        $RAW_QUERY  = "select * from city where city.sta_id =". $_POST['id'];

        $statement  = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $state    	= $statement->fetchAll();

        $response = new Response(json_encode($state));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function ViewsProfiles( Request $request , $id_profile){
        // Validar si la Cookie se ha seteado
        if(empty($_COOKIE['contador']))
        {
            // Obtener La Ip del visitante.
            $em     = $this->getDoctrine()->getManager();
            $ip     = $this->getRealIP();

            $oUsr   = $em->getRepository('AppBundle:User')->findOneBy( array('usrId' => $id_profile) );

            $visitas = new UserViews();
            $visitas->setVisUsu( $oUsr );
            $visitas->setVisReferencia($ip);
            $visitas->setVisFechaCrea(new \DateTime("now"));

            $em->merge($visitas);
            $em->flush();

            setcookie('contador', 1, time() + 365 * 24 * 60 * 60, $request->getRequestUri());
        }
    }

    private function getRealIP()
    {

        if ($_SERVER['SERVER_NAME'])
        {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'] ))
            {
                $sIpAddress = @$_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_CLIENT_IP"] ))
            {
                $sIpAddress = @$_SERVER["HTTP_CLIENT_IP"];
            }
            else
            {
                $sIpAddress = @$_SERVER["REMOTE_ADDR"];
            }
        }
        return $sIpAddress;
    }

    public function calcular_tiempo_trasnc($hora1,$hora2)
    {
        $separar[1]=explode(':',$hora1);
        $separar[2]=explode(':',$hora2);

        $total_minutos_trasncurridos[1] = (preg_replace("/[^0-9]/", "", $separar[1][0])*60)+ preg_replace("/[^0-9]/", "", $separar[1][1]);
        $total_minutos_trasncurridos[2] = (preg_replace("/[^0-9]/", "", $separar[2][0])*60)+preg_replace("/[^0-9]/", "", $separar[2][1]);

        //$total_minutos_trasncurridos[1] = ($separar[1][0]*60) + $separar[1][1];
        //$total_minutos_trasncurridos[2] = ($separar[2][0]*60)+ $separar[2][1];
        $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];
        if($total_minutos_trasncurridos<=59){
            //return($total_minutos_trasncurridos.' Minutos');
            return($total_minutos_trasncurridos);
        }
        else if($total_minutos_trasncurridos>59)
        {
            $HORA_TRANSCURRIDA = round($total_minutos_trasncurridos/60);
            if($HORA_TRANSCURRIDA<=9)
            {
                $HORA_TRANSCURRIDA='0'.$HORA_TRANSCURRIDA;
            }
            $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos%60;
            if($MINUITOS_TRANSCURRIDOS<=9)
            {
                $MINUITOS_TRANSCURRIDOS='0'.$MINUITOS_TRANSCURRIDOS;
            }
            //return ($HORA_TRANSCURRIDA.':'.$MINUITOS_TRANSCURRIDOS.' Horas');
            return $Minutos = ($HORA_TRANSCURRIDA * 60)+$MINUITOS_TRANSCURRIDOS;

        }
    }

    public function rangos($arr)
    {

        $pros = 1;
        $total = count($arr);
        $cadena = "";
        $block = false;
        for($i=0; $i < count($arr); $i++)
        {
            if($pros < $total)
            {
                //$res = abs( $this->calcular_tiempo_trasnc($hora1=  $arr[$i], $hora2=$arr[$i+1]) );
                $res = abs( $this->calcular_tiempo_trasnc($hora1=date("H:i", strtotime($arr[$i]))  , $hora2=date("H:i", strtotime($arr[$i+1])) ) );
                if( $pros == 1 )
                {
                    $cadena .= date('ga', strtotime($arr[$i]));
                }
                else
                {
                    if( $res != 60 )
                    {
                        // 12-hour time to 24-hour time
                        //$time_in_24_hour_format  = date("H:i", strtotime("1:30 PM"));

                        $cadena .= " <i>to</i> ". $this->renderHours($arr[$i]);// date('ga', strtotime($arr[$i])  );
                        $block=true;
                    }
                    else
                    {
                        if( $block )
                        {
                            $cadena .= "<br /> ". date('ga', strtotime($arr[$i]));
                            $block = false;
                        }
                    }
                }
            }
            else
            {
                $cadena .= " <i>to</i> " .$this->renderHours($arr[$i]);//date('ga', strtotime($arr[$i]) );
            }
            $pros++;

        }
        return $cadena;
    }

    public function renderHours($horaInicial)
    {
        $horaInicial=$horaInicial;//"14:00";
        $minutoAnadir=60;

        $segundos_horaInicial=strtotime($horaInicial);

        $segundos_minutoAnadir=$minutoAnadir*60;

        $nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);

        return date('ga', strtotime($nuevaHora)  );
    }

    public function landingAction( Request $request ){

        $em     = $this->getDoctrine()->getManager();
        /*
        *   Obtain all profiles data
        */
        $_state     =   $request->query->get('state');
        $_city      =   $request->query->get('city');
        $_speciality=   $request->query->get('speciality');
        $_country   =   $request->query->get('country');
        $_filter    ='';
        $zoom = 0;
        $stado_lat_lng=0;
        $busqueda = array();
        $citis = 0;
        $countries = 0;
        $estados_d = 0;

        $busqueda['_STATE']=0;
        $busqueda['_CITY']=0;
        $busqueda['_SPECI']=0;
        $busqueda['_COUNTRY']=0;

        //$sBusqueda = $request->query->get('b');
        $sUsuarios = '';
        if (!empty($_state) or !empty($_city) or !empty($_speciality)) {

            $_SESSION['_STATE']     = $_state;
            $_SESSION['_CITY']      = $_city;
            $_SESSION['_SPECI']     = $_speciality;
            $_SESSION['_COUNTRY']   = $_country;

            $busqueda['_STATE']     = $_SESSION['_STATE'];
            $busqueda['_CITY']      = $_SESSION['_CITY'];
            $busqueda['_SPECI']     = $_SESSION['_SPECI'];
            $busqueda['_COUNTRY']   = $_SESSION['_COUNTRY'];

            if($_state){
                $_filter .= ' and s.sta_id='.$_state;

                if ($_city){
                    $_filter .= ' and ci.cit_id ='.$_city;
                }
            }
            if ($_speciality != 0){
                $_filter .= ' and ues.sp_id ='.$_speciality;
            }

            if(isset($_state)){
                $sql_estado = "select * from state where sta_id = ".$_state;
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $estados_d = $statement->fetchAll();
            }

            // Obteniendo todas las cities del estado en session
            if(isset($_SESSION['_CITY'])){
                $sql_estado = "select * from city where sta_id = ". $_SESSION['_STATE'];
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $citis = $statement->fetchAll();
            }
            if(isset($_country)){
                $sql_estado = "select * from country where cou_id = ". $_SESSION['_COUNTRY'];
                $statement  = $em->getConnection()->prepare($sql_estado);
                                $statement->execute();
                $countries = $statement->fetchAll();
            }

            $zoom = 1;
        }else{
            $sql_estado = "select * from state where sta_id = 1";
            $statement  = $em->getConnection()->prepare($sql_estado);
                            $statement->execute();
            $estados_d= $statement->fetchAll();

            $zoom = 0;

            //$_filter .= ' and ca.cat_id = 1';
        }



        $state      = $em->getRepository('AppBundle:State')->findBy( array('cou' => $_country) );
        $speciality = $em->getRepository('AppBundle:Speciality')->findAll();
        $country    = $em->getRepository('AppBundle:Country')->findAll();
        $category   = $em->getRepository('AppBundle:Category')->findBy( array('catActive' => 1) );

        $RAW_QUERY  = "select  u.usr_id, md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code,ca.cat_icon,
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1,ca.cat_id,ci.ci_company,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
            LEFT JOIN state as s on s.sta_id = c.sta_id

            LEFT JOIN user_has_speciality AS ues ON ues.usr_id = u.usr_id
            LEFT JOIN speciality as e on e.sp_id = ues.sp_id
            LEFT JOIN category AS ca ON ca.cat_id = ci.cat_id
            WHERE u.usr_active = 1 AND ci.ci_lat != '' AND ( SELECT pay_deadline FROM payer WHERE pay_deadline >= CURDATE() AND usr_id = u.usr_id ORDER BY pay_deadline DESC LIMIT 1 ) >= CURDATE() $_filter
            group by u.usr_id ";
        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                      $statement->execute();
        $medic      = $statement->fetchAll();


        /**
        * @VAR $paginator \Knp\Component\Pager\Paginator
        */
        $paginator = $this->get('knp_paginator');
                        $pagination = $paginator->paginate(
                                $medic,
                                $request->query->getInt('page', 1),
                                50);

        $geo = $this->geoIP();
        if( is_object($geo)  && $geo != "" )
        {
            $isoCode = strtoupper($geo->country->isoCode);
        }
        else
        {
            $isoCode = "US";
        }

        $cur = $this->currentLatLngUser( $isoCode );
        $currentUserLat = $cur["lat"];
        $currentUserLng = $cur["lng"];

        return $this->render('web/default/landing.html.twig' ,array('country'=> $country,'state'=> $state , 'cities'=>$citis , 'speciality' => $speciality , 'medic' => $pagination , 'zoom' => $zoom , 'category'=> $category, "currentUserLat" => $currentUserLat,
        "currentUserLng" => $currentUserLng ) );
    }

    public function contactusAction( Request $request ){

        $em     = $this->getDoctrine()->getManager();

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $message = $request->get('message');


        if( $request ){

            $contactus = new Contactus();
            $contactus->setConName( $name );
            $contactus->setConEmail( $email );
            $contactus->setConPhone( $phone );
            $contactus->setConComment( $message );
            $contactus->setConCreate( new \DateTime("now") );

            $em->merge($contactus);
            //$em->flush();

            $flush = $em->flush();
            if($flush == null){
                $success = 1;
                $this->session->getFlashBag()->add("success",$success);
            }else{
                $error = 0;
                $this->session->getFlashBag()->add("error",$error);
            }
        }

        return $this->redirectToRoute("web_landing");

    }

    public function sendContactFormToDoctorAction( Request $request /*, \Swift_Mailer $mailer*/ ){
        $name = $request->get("name");
        $email = $request->get("email");
        $msg = $request->get("message");
        $profileId = $request->get("profileId");

        if ($request->isMethod('POST') && is_numeric($profileId) && is_numeric($profileId) > 0 )
        {
            $em = $this->getDoctrine()->getManager();

            $oDetail = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array("usr"=>$profileId ) );
            if( !$oDetail )
            {
                throw new NotFoundHttpException("Profile not found");
            }

            $fullNameProfile = $oDetail->getMdFirstName()." ".$oDetail->getMdMiddleName()." ".$oDetail->getMdFirstSurname()." ".$oDetail->getMdSecondSurname();

            //Get emails
            $RAW_QUERY  = "SELECT uhsn.usn_link FROM social_network sn
                            INNER JOIN user_has_social_network uhsn ON sn.sn_id = uhsn.sn_id
                            WHERE uhsn.usr_id = $profileId
                            AND sn.sn_key = 'email' AND uhsn.usn_active = 1";

            $statement  = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
            $result    	= $statement->fetchAll();
            /*
            if ( count($result) > 0 )
            {
                $to = implode(",",$result[0]); //"emails split it per comma"
            }else{
                $to = $oDetail->getUsr()->getUsrEmail();
            }
            */
            /*
            // the message
            $subject = "Contact Form - $name";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


            $view = $this->renderView( 'web/default/contactEmail.html.twig',
                array(
                    'fullNameProflie'=>$fullNameProfile,
                    'name' => $name,
                    "email"=>$email,
                    "msg"=>$msg
                    )
            );
            $message = $view;
            // More headers
            $headers .= "From: <$email>" . "\r\n";
            //$headers .= 'Cc: myboss@example.com' . "\r\n";
            $headers .= "Reply-To: $email" . "\r\n";

            if( mail($to,$subject,$message,$headers) )
            {
                echo 1;
            }
            else
            {
                echo "Error";
            }
            */
            /*
                $message = \Swift_Message::newInstance()//(new \Swift_Message('Hello Email'))
                ->setFrom($email)
                ->setTo('gialvarezlopez@gmail.com')
                ->setBody(
                    $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'web/default/contactEmail.html.twig',
                        array('name' => $name)
                    ),
                    'text/html'
                )

                ;
                $this->get('mailer')->send($message);
                //$mailer->send($message);

                // or, you can also fetch the mailer service this way
                // $this->get('mailer')->send($message);

                //return $this->render(...);
            */



            $view = $this->renderView( 'web/default/contactEmail.html.twig',
                array(
                    'fullNameProflie'=>$fullNameProfile,
                    'name' => $name,
                    "email"=>$email,
                    "msg"=>$msg
                    )
            );

            $mail = new PHPMailer();
            //$mail->isSMTP();
            //$mail->Host = 'mail.doctorsbillboard.com';
            //$mail->SMTPAuth = true;
            //$mail->Username = 'info@doctorsbillboard.com';
            //$mail->Password = '';
            //$mail->SMTPSecure = 'tls';
            //$mail->Port = 25;
            //$mail->setFrom('acedmy@leewayweb.com', 'Leeway Academy');
			$mail->setFrom($email, $name);

            if ( count($result) > 0 )
            {
                for( $i=0; $i < count($result); $i++)
                {
                    $mail->addAddress($result[$i]['usn_link']);
                }
            }else{
                $mail->addAddress($oDetail->getUsr()->getUsrEmail());
            }


            //Content
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Contact Form';
            $mail->Body    =  $view;
            $mail->AltBody = '';
            if(!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            } else {
                echo 1;
            }

        }
        else
        {
            throw new Exception('Error');
        }

        exit();
    }
}
