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
        /*
        *   Obtain all profiles data
        */
        $_state     =   $request->query->get('state');
        $_city      =   $request->query->get('city');
        $_speciality=   $request->query->get('speciality');
        $_filter    ='';


        //$sBusqueda = $request->query->get('b');
        $sUsuarios = '';
        if (!empty($_state) or !empty($_city) or !empty($_speciality)) {

            if(!empty($_state)){
                $_filter = ' and dep.dep_id='.$_estado;
            }elseif(!empty($_city)){
                $_filter .= ' and m.mun_id='.$_cities;
            }elseif(!empty($_speciality)){
                $_filter .= ' and e.esp_id='.$_espe;
            }
            
        }


    	$em 	= $this->getDoctrine()->getManager();        
        $state 	= $em->getRepository('AppBundle:State')->findAll();
        $speciality  = $em->getRepository('AppBundle:Speciality')->findAll();

        $RAW_QUERY	= "select md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, 
                        ci.ci_lat,ci.ci_lng,ci.ci_address,ci.ci_phone1,
                        group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla 
                        from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u 
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
			LEFT JOIN state as s on s.sta_id = c.sta_id
			LEFT JOIN speciality as e on e.usr_id = u.usr_id
            where md.md_active = 1 $_filter
            group by u.usr_id limit 3";
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
                                3);
           

        return $this->render('web/default/index.html.twig', array('state'=> $state , 'medic' => $pagination, 'speciality' => $speciality ));
    }

    public function detailprofile( Request $request){

        /*
        *   Obtain profile detail by user
        */
        $id_profile = 0;
        if($request->get("id")){
            $id_profile = $request->get("id");
        }

        $em     = $this->getDoctrine()->getManager();        

        $RAW_QUERY  = "select md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, group_concat(e.sp_name SEPARATOR ', ') as esp, (select count(*) as totla from user_views as userV where userV.vis_usu_id = u.usr_id ) as total from user as u 
            LEFT JOIN medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
            LEFT JOIN state as s on s.sta_id = c.sta_id
            LEFT JOIN speciality as e on e.usr_id = u.usr_id
            where u.usr_id = ". $id_profile ."
            group by u.usr_id";

        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                      $statement->execute();    
        $medic      = $statement->fetchAll();        

        return $this->render('web/default/detail.html.twig', array( 'medic' => $medic ));
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

    private function ViewsProfiles(){
        // Validar si la Cookie se ha seteado
        if(empty($_COOKIE['contador']))
        {
            // Obtener La Ip del visitante.
            $ip = $this->getRealIP();

            $oUsr   = $em->getRepository('AppBundle:User')->findOneBy( array('usrId' => 1) );     

            $visitas = new UserViews();
            $visitas->setVisUsu( $oUsr );
            $visitas->setVisReferencia($ip);
            $visitas->setVisFechaCrea(new \DateTime("now"));

            $em->merge($visitas);
            $em->flush();

            //setcookie('contador', 1, time() + 365 * 24 * 60 * 60, $request->getRequestUri());
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
}
