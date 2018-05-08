<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        $RAW_QUERY	= "select * from user as u left join medical_detail as md on u.usr_id = md.usr_id";
        $statement  = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();    
        $medic    	= $statement->fetchAll();
        
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
}
