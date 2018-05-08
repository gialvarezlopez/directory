<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //return $this->render('WebBundle:Default:index.html.twig');
        return $this->render('web/default/index.html.twig', array());
    }
}
