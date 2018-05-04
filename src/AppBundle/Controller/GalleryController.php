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
class GalleryController extends Controller
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
        $galleries = $em->getRepository('AppBundle:Gallery')->findBy( array("usr"=> $userId) );


        return $this->render('app/gallery/index.html.twig', array(
            'galleries' => $galleries,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
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

    public function deleteAction( Request $request, Gallery $gallery ){
        
        $id = $request->get("id");
        $key = $request->get("key");
        $userId = $this->getUser()->getUsrId();
		if($id && $key)
		{
			$em = $this->getDoctrine()->getManager();
            $q = $em->createQuery("DELETE FROM AppBundle\Entity\Gallery tb WHERE tb.gaId = ".$id ." AND tb.gaName='".$key."' AND tb.usr=".$userId);
            if( $q->execute() ){
                @unlink( __DIR__.'/../../../web/uploads/'.$key);
                echo 1;
            }else{
                echo json_encode(['error'=>"Record couldn't be deleted."]);
            }
           
		}else{
            echo json_encode(['error'=>'Select a file to delete it.']);
        }
        exit();
	}

}
