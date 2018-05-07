<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use AppBundle\Entity\User;


class SettingsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();

        return $this->render('app/settings/index.html.twig', array(
            //'galleries' => $galleries,
        ));
    }

    public function changepasswordAction(Request $request) {
        $session = $request->getSession();
        
        if($request->getMethod() == 'POST') {
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

}
