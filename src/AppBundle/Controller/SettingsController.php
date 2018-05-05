<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use AppBundle\Entity\User;
use AppBundle\Entity\Gallery;
use AppBundle\Form\GalleryType;

/**
 * Gallery controller.
 *
 */
class SettingsController extends Controller
{

    //var $pathImages = __DIR__.'/../../web/uploads/';
    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        //$galleries = $em->getRepository('AppBundle:Gallery')->findBy( array("usr"=> $userId) );


        return $this->render('app/settings/index.html.twig', array(
            //'galleries' => $galleries,
        ));
    }
    /*
    public function newAction(Request $request)
    {
        $file = $request->files->get('images');
       
        if (!$file) {
            echo json_encode(['error'=>'No files found for upload.']); 
            exit(); 
        }

        $ext=$file[0]->guessExtension();
        $file_name=md5(uniqid()).".".$ext;

        if( !$file[0]->move("uploads", $file_name) )
        {
            echo json_encode(['error'=>'No files found for upload.']); 
        }else{
            
            $em = $this->getDoctrine()->getManager();
            
            $userId = $this->getUser()->getUsrId();
            $gallery = new Gallery();
            $gallery->setGaName($file_name);
            
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrId"=> $userId) );
            $gallery->setUsr($oUser);

            $em->persist($gallery);
            $flush = $em->flush();
            if( $flush == null )
			{
                echo 1;
			}
            else
            {
			    echo json_encode(['error'=>'No record was no saved.']);
			}
            
        }
        exit();
                    
    }
    */
}
