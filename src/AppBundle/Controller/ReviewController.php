<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReviewController extends Controller
{

    public function indexAction()
    {
        //$em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();

        $link = $this->generateUrl(
            'web_show_profile', [
                'id'=>$userId
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    

        return $this->render('app/review/index.html.twig', array(
            'userId' => $userId,
            "url"=>$link
        ));
    }



}
