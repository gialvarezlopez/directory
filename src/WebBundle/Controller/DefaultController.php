<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserViews;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();   
        /*
        *   Obtain all profiles data
        */
        $_state     =   $request->query->get('state');
        $_city      =   $request->query->get('city');
        $_speciality=   $request->query->get('speciality');
        $_filter    ='';
        $zoom = 0;
        $stado_lat_lng=0;

        //$sBusqueda = $request->query->get('b');
        $sUsuarios = '';
        if (!empty($_state) or !empty($_city) or !empty($_speciality)) {
            if($_state){
                $_filter .= ' and s.sta_id='.$_state;

                if ($_city){
                    $_filter .= ' and ci.cit_id ='.$_city;
                }
            }
            if ($_speciality != 0){
                $_filter .= ' and ues.sp_id ='.$_speciality;
            }

            $sql_estado = "select * from state where sta_id = ".$_state;
            $statement  = $em->getConnection()->prepare($sql_estado);
                            $statement->execute();    
            $stado_lat_lng= $statement->fetchAll(); 

            $zoom = 1;        
        }else{
            $sql_estado = "select * from state where sta_id = 1";
            $statement  = $em->getConnection()->prepare($sql_estado);
                            $statement->execute();    
            $stado_lat_lng= $statement->fetchAll(); 
        }
    	     
        $state 	= $em->getRepository('AppBundle:State')->findAll();      


        $speciality  = $em->getRepository('AppBundle:Speciality')->findAll();

        $RAW_QUERY	= "select  u.usr_id, md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, 
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla 
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u 
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
			LEFT JOIN state as s on s.sta_id = c.sta_id
            
			LEFT JOIN user_has_speciality AS ues ON ues.usr_id = u.usr_id
            LEFT JOIN speciality as e on e.sp_id = ues.sp_id
            where md.md_active = 1 and ci.ci_lat != '' $_filter
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
                                6);
           

        return $this->render('web/default/index.html.twig', array('state'=> $state , 'medic' => $pagination, 'speciality' => $speciality , 'zoom' => $zoom , 'stateDatos' => $stado_lat_lng ));
    }

    public function showProfileAction( Request $request){

        /*
        *   Obtain profile detail by user
        */
        $id_profile = 0;
        if($request->get("id")){
            $id_profile = $request->get("id");
        }

        $em     = $this->getDoctrine()->getManager();        

        $RAW_QUERY  = "select  u.usr_id, md.md_first_name,  ci.ci_company,ci.ci_schedule,md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, md.md_profile_description, md.md_academic_training,md.md_professional_experience,md.md_courses_seminars,md.md_aditional_information,
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1, ci.ci_phone2,u.usr_email,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla 
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u 
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
            LEFT JOIN state as s on s.sta_id = c.sta_id
            LEFT JOIN speciality as e on e.usr_id = u.usr_id
            where u.usr_id = ". $id_profile ."
            group by u.usr_id";

        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                      $statement->execute();    
        $profile      = $statement->fetchAll();   

        //Obtain gallery

        $RAW_GALLERY    = "select * from gallery where usr_id = ".$id_profile;
        $statement      = $em->getConnection()->prepare($RAW_GALLERY);
                          $statement->execute();
        $gallery        = $statement->fetchAll();  

        //Obtain Social Network 
        $RAW_Social     = "select * from user_has_social_network usn left join social_network as sn on 
                            usn.sn_id = sn.sn_id where usr_id =".$id_profile;
        $statement      = $em->getConnection()->prepare($RAW_Social);
                          $statement->execute();
        $social_network = $statement->fetchAll();  

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

        return $this->render('web/default/showProfile.html.twig', array( 'profile' => $profile ,"horario" => $horaDias, "hoy" => $hoy, 'gallery' => $gallery , 'social_network' => $social_network ));
    }

    public function showFullProfileAction( Request $request ){
        return $this->render('web/default/showProfile.html.twig');
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

        $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
        $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
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
                $res = abs( $this->calcular_tiempo_trasnc($hora1=$arr[$i],$hora2=$arr[$i+1]) );
                if( $pros == 1 )
                {
                    $cadena .= date('ga', strtotime($arr[$i]));
                }
                else
                {
                    if( $res != 60 )
                    {
                        $cadena .= " <i>a</i> ". date('ga', strtotime($arr[$i]));
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
                $cadena .= " <i>a</i> " .date('ga', strtotime($arr[$i]));
            }
            $pros++;

        }
        return $cadena;
    }
}
