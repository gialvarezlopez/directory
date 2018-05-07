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

    public function changepasswordAction(Request $request) {
        $session = $request->getSession();
        
        if($request->getMethod() == 'POST') {
            //EXIT("SALI");
            $old_pwd = $request->get('currentPass');
            $new_pwd = $request->get('newPass');
            $repeatPass = $request->get("repeatPass");
            //echo $user = $this->getUser();
            
            $user= $this->get('security.token_storage')->getToken()->getUser();
            //$user->getPassword();


            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $old_pwd_encoded = $encoder->encodePassword($old_pwd, $user->getSalt());
            //echo $old_pwd_encoded;
            if($user->getPassword() != $old_pwd_encoded) {
                $session->getFlashBag()->set('error', "Wrong old password!");
            } else {
                if( $new_pwd != $repeatPass )
                {
                    $session->getFlashBag()->set('error', "The passwords do not match, try again!");
                }
                else
                {
                    $new_pwd_encoded = $encoder->encodePassword($new_pwd, $user->getSalt());
                    $user->setUsrPassword($new_pwd_encoded);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);
    
                    $manager->flush();
                    $session->getFlashBag()->set('success', "Password changed successfully!");
                }
                
            }
        }
        return $this->redirectToRoute('settings_show');
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
