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
    public function indexAction()
    {
    	$em 	= $this->getDoctrine()->getManager();        
        $state 	= $em->getRepository('AppBundle:State')->findAll();

        $RAW_QUERY	= "select md.md_first_name, md.md_first_surname,c.cit_name,s.sta_name,md.md_profile_image,s.sta_code, group_concat(e.sp_name SEPARATOR ', ') as esp from user as u left join medical_detail as md on u.usr_id = md.usr_id left join contact_info as ci on ci.usr_id = u.usr_id left join city as c on c.cit_id = ci.cit_id
			left join state as s on s.sta_id = c.sta_id
			left join speciality as e on e.usr_id = u.usr_id group by u.usr_id";
        $statement  = $em->getConnection()->prepare($RAW_QUERY);
        			  $statement->execute();    
        $medic    	= $statement->fetchAll();

        // Validar si la Cookie se ha seteado
        if(empty($_COOKIE['contador']))
        {
            // Obtener La Ip del visitante.
            $ip = $this->getRealIP();

            $id_user['user'] 	= $em->getRepository('AppBundle:User')->findBy( array('usrId' => 1) );      

            $visitas = new UserViews();
            //$visitas->setVisUsu( $id_user['user'] );
            $visitas->setVisReferencia($ip);
            $visitas->setVisFechaCrea(new \DateTime("now"));

            //$em->persist($visitas);
            //$em->flush();

            //setcookie('contador', 1, time() + 365 * 24 * 60 * 60, $request->getRequestUri());
        }


        
        return $this->render('web/default/index.html.twig', array('state'=> $state , 'medic' => $medic ));
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
