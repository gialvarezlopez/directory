<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use AppBundle\Entity\User;
use AppBundle\Entity\UserResetPassword;
use AppBundle\Form\UserType;

class UserController extends Controller
{

    private $session;
	
	public function __construct() {
		$this->session = new Session();
	}

    public function loginAction( Request $request)
    {

        /*
            //http://www.techjini.com/blog/symfony3-integrating-social-media-authentication/

            //Google
            $client= new \Google_Client();
            $client->setApplicationName("medicdirectory");// to set app name
            $client->setClientId("862291422120-79hqr4r3hpvl50lf2ba9t6kic6qkug70.apps.googleusercontent.com");// to set app id or client id
            $client->setClientSecret("cou057-1jLR9fi_rDfpGxjBM");// to set app secret or client secret
            $client->setRedirectUri("http://localhost:8000/symfony3/directory/web/app_dev.php/register");// to set redirect uri
            $client->setHostedDomain("http://your-hosted-domain.com");// to set hosted domain (optional)
            $client->addScope(array(
                "https://www.googleapis.com/auth/plus.login",
                "https://www.googleapis.com/auth/userinfo.email",
                "https://www.googleapis.com/auth/userinfo.profile",
                "https://www.googleapis.com/auth/plus.me"
                ));
            $urlGoogle= $client->createAuthUrl();// to get login url

            //Facebook
            $fb = new \Facebook\Facebook(["app_id" => "2096043027298111","app_secret" => "d6d2770f83eba3cea61c4b63b7b3487e" ]);
            $helper = $fb->getRedirectLoginHelper();// to set redirection url
            $permissions = ["email"];// set required permissions to user details
            $urlFacebook = $helper->getLoginUrl("http://link.com/app_dev.php/fbcheck", $permissions);
            //echo ‘<a href=”‘ . $loginUrl . ‘”>Log in with Facebook!</a>’;die;
        */
        $recoveryToken = $request->get('token');
        $tokenConfirmation = $request->get('tokenConfirmation');
        if( $recoveryToken != "" && !isset($tokenConfirmation) )
        {
            $em = $this->getDoctrine()->getManager();
            $oReset = $em->getRepository('AppBundle:UserResetPassword')->findOneBy( array("uspToken"=> $recoveryToken, "uspActive"=>1) );
            //echo count($oReset);
            if( $oReset )
            {
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                try {
                    $userId = $oReset->getUsr()->getUsrId();
                    $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrId"=> $userId, "usrActive"=>1) );
                    if($oUser)
                    {
                        if( $oReset->getUsr()->getUsrForgotPassword() == 1 )
                        {
                            $oUser->setUsrForgotPassword(0);
                            $oUser->setUsrPassword( $oReset->getUspNewPassword() );
                            $oUser->setUsrUpdated( new \datetime("now") );
                            $em->persist($oUser);			
                            $flush = $em->flush();

                            if($flush == null )
                            {
                                $q = $em->createQuery('delete from AppBundle\Entity\UserResetPassword tb where tb.usr = '.$userId );
                                $q->execute();



                                $em->getConnection()->commit();
                                $msg = "The token was validated successfully enter the new password and your email address, just remember to  change the password when you obtain access in the '<strong>setting</strong> menu'";
                                $this->session->getFlashBag()->add("success", $msg);
                                return $this->redirectToRoute('login');
                            }
                        }
                        else
                        {
                            $msg = "The token is not valid";
                            $this->session->getFlashBag()->add("error", $msg);
                        }
                        
                    }
                    else
                    {
                        $msg = "There was an error to try to validate the token, try again";
                        $this->session->getFlashBag()->add("error", $msg);
                    }
                    
                }
                catch (Exception $e) {
                    $em->getConnection()->rollBack();
                    throw $e;
                }
            }
            else
            {
                $msg = "The token no longer exists";
                $this->session->getFlashBag()->add("error", $msg);
            }

            //$msg = "You have validated the new password, now you can access using the same email address and new password, just remember change it";
            //$this->session->getFlashBag()->add("success", $msg);
        }

        if( $tokenConfirmation != "" && !isset($recoveryToken) )
        {
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrTokenConfirmation"=> $tokenConfirmation, "usrActive"=>1, "usrStatus"=>0) );
            if( $oUser )
            {
                $oUser->setUsrStatus(1);
                $oUser->setUsrUpdated( new \datetime("now") );
                $em->persist($oUser);			
                $flush = $em->flush();
                if($flush == null )
                {
                    $msg = "User validation confirmed successfully, now you can login";
                    $this->session->getFlashBag()->add("success", $msg);
                }
            }
        }

        $urlGoogle = "";
        $urlFacebook = "";

        $authenticationUtils = $this->get("security.authentication_utils"); 
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('app/user/login.html.twig', array(
            'error' => $error,
            "last_username"=> $lastUsername,
            "urlGoogle"=>$urlGoogle,
            "urlFacebook" => $urlFacebook
        ));
        //return $this->render("AppBundle:user:login.html.twig");
    }

    public function registerAction( Request $request)
    {
        //$this->sendEmailRegister("gialvarezlopez@gmail.com");
        /*
            $client= new \Google_Client();
            $client->setApplicationName("medicdirectory");// to set app name
            $client->setClientId("862291422120-79hqr4r3hpvl50lf2ba9t6kic6qkug70.apps.googleusercontent.com");// to set app id or client id
            $client->setClientSecret("cou057-1jLR9fi_rDfpGxjBM");// to set app secret or client secret
            $client->setRedirectUri("http://localhost:8000/symfony3/directory/web/app_dev.php/register");// to set redirect uri
            $client->setHostedDomain("http://your-hosted-domain.com");// to set hosted domain (optional)
            $service = new \Google_Service_Oauth2($client);
            $code= $client->authenticate($request->query->get("code"));// to get code
            $client->setAccessToken($code);// to get access token by setting of $code
            $userDetails=$service->userinfo->get();// to get user detail by using access token
            var_dump($userDetails);die;
        */

        /*
            $authenticationUtils = $this->get("security.authentication_utils"); 
            //$authenticationUtils = $this->get("security.authentication.manager");
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();
        */
        
        $user = new User();
        //Crea un usuario nuevo
		
		$form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //var_dump($form);
        if( $form->isSubmitted() )
        {
            //echo "sali";
            if( $form->isValid())
            {
                $email = $form->get("usrEmail")->getData();
                $em = $this->getDoctrine()->getManager();
                $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrEmail"=>$email ) );
                if( !$oUser ) //No exists the email in DB
                {
                    $em->getConnection()->beginTransaction(); // suspend auto-commit
                    try
                    {
                        //$user = new User();
                        //$user->setUsername($form->get("username")->getData());
                        
                        $user->setUsrEmail($email);
                        
                        $user->setCou($form->get("cou")->getData());
                        
                        //Encripta el password del usuario
                        $factory = $this->get("security.encoder_factory");
                        $encoder = $factory->getEncoder($user);
                        $password = $encoder->encodePassword( $form->get("usrPassword")->getData(), $user->getSalt() );
                        //End 
                        
                        $user->setUsrPassword( $password );
                        $user->setUsrRole("ROLE_USER");
                        $user->setUsrCreated(new \DateTime());
                        $user->setUsrUpdated(null);

                        //token creation
                        $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
                        $user->setUsrStatus(0);
                        $user->setUsrTokenConfirmation($token);

                        //$em = $this->getDoctrine()->getManager();
                        $em->persist($user);
                        $flush = $em->flush();
                        
                       
                            
                            //Send an email confirmation
                            //$this->sendEmailNewUserConfirmation ($email, $token);
                            //return $this->redirectToRoute("payments_info");

                            //This code will be no longer in use
                            /*
                                //==================================
                                //Loggin after register
                                //==================================
                                    $providerKey = 'main'; // your firewall name
                                    $token = new UsernamePasswordToken($user, $password, $providerKey, $user->getRoles());
                                    $this->get('security.token_storage')->setToken($token);
                                    $this->get("session")->set("_security_main", serialize($token));
                                //end
                                $url = $this->generateUrl('gallery_index');
                                return $this->redirect($url);
                            */

                        $res = $this->sendEmailNewUserConfirmation($email, $token);
                        if( $res == 1 )
                        {
                            
                            $em->getConnection()->commit();
                            $typeMsg = "success";
                            $status = "To validate the user creation it was sent you an email confirmation, it's possible the email show up in spam, this can take a little bit minutes";
                            $this->session->getFlashBag()->add($typeMsg, $status);
                            return $this->redirectToRoute("login");
                        }
                        else
                        {
                            $typeMsg = "error";
                            $status = "There was an error to create the user";
                            $this->session->getFlashBag()->add($typeMsg, $status);
                        }
                        
                    }
                    catch (Exception $e) {
                        $em->getConnection()->rollBack();
                        throw $e;
                    }
                }
                else
                {
                    $typeMsg = "error";
                    $status = "Error: Username already exists";
                    $this->session->getFlashBag()->add($typeMsg, $status);
                } 

			}else{
                $typeMsg = "error";
                $status = "The form is not valid";
                $this->session->getFlashBag()->add($typeMsg, $status);
			}
		}

        return $this->render('app/user/register.html.twig', array(
            //'error' => $error,
            //"last_username"=> $lastUsername
            "form" => $form->createView(),
        ));
        //return $this->render("AppBundle:user:login.html.twig");
    }


    public function rememberPasswordAction( Request $request )
    {
        $email = $request->get('email');
        if( $request->isMethod('POST') && $email != "")
        {
            $em   = $this->getDoctrine()->getManager();
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrEmail"=>$email ) );
            if( $oUser )
            {
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                try {
                    $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());
                    
                    $q = $em->createQuery('delete from AppBundle\Entity\UserResetPassword tb where tb.usr = '.$oUser->getUsrId());
                    $q->execute();
                    
                    $reset = new UserResetPassword();
                    $reset->setUspToken($token);
                    
                    $tempPassword = str_shuffle("abcdefghijklmnopqrstuvwxyz");
                    //Encripta el password del usuario
				    $factory = $this->get("security.encoder_factory");
				    $encoder = $factory->getEncoder($oUser);
				    $newPassword = $encoder->encodePassword( $tempPassword, $oUser->getSalt() );
				    //End 
                    
                    $reset->setUspNewPassword($newPassword);
                    $reset->setUspCreated( new \Datetime("now") );
                    $reset->setUspActive(1);
                    $reset->setUsr($oUser);                    
                    $em->persist($reset);
                    $em->flush($reset);

                    $oUser->setUsrForgotPassword(1);
                    $em->persist($oUser);
                    $em->flush();

                    $resSendEmail = $this->sendEmailRememberPassword($email, $token, $tempPassword);
                    if( $resSendEmail == 1 )
                    {
                        $em->getConnection()->commit();
                        echo 1;//$password;
                    }else{
                        echo "Error to try to send the email";
                        $em->getConnection()->rollBack();
                    }    
                    
                }
                catch (Exception $e) {
                    $em->getConnection()->rollBack();
                    throw $e;
                }
                
            }
            else
            {
                echo 0;
            }
            
        }
        else
        {
            throw new Exception('Error');
        }
        exit();
    }

    public function sendEmailRememberPassword($email, $token, $tempPassword)
    {
        if( isset($email) && $email !== "" )
        {
            $view = $this->renderView('app/emailTemplates/remeberPassword.html.twig', 
                array(
                    'token'=>$token, 
                    'password' => $tempPassword,
                    ) 
            );

            $mail = new PHPMailer();
            $mail->setFrom("support@doctorsbillboard.com");
            $mail->addAddress($email); 
            //Content
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body    =  $view;
            $mail->AltBody = '';
            if(!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            } else {
                return 1;
            }    
        }
    }

    public function sendEmailNewUserConfirmation ($email, $token )
    {
        if( isset($email) && $email !== "" )
        {
            $view = $this->renderView('app/emailTemplates/registerConfirmation.html.twig', 
                array(
                    'token'=>$token, 
                    //'password' => $tempPassword,
                    ) 
            );

            $mail = new PHPMailer();
            $mail->setFrom("support@doctorsbillboard.com");
            $mail->addAddress($email); 
            //Content
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'New User Confirmation';
            $mail->Body    =  $view;
            $mail->AltBody = '';
            if(!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            } else {
                return 1;
            }    
        }
    }
}
