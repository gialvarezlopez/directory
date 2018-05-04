<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\User;
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
        $this->sendEmailRegister("gialvarezlopez@gmail.com");
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
            echo "sali";
            if( $form->isValid())
            {
                //$user = new User();
                //$user->setUsername($form->get("username")->getData());
                $email = $form->get("usrEmail")->getData();
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
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$flush = $em->flush();
				
				if ($flush == null ){
                    $status = "Use was created successfuly";
                    
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
                   

					$this->sendEmailRegister($email);
					
				}else{
					$status = "There was an error";
				} 

			}else{
				$status = "The form is not valid";

			}

            $this->session->getFlashBag()->add("status",$status);
            echo $status;
            exit("sali");
			//return $this->redirectToRoute("lips_login");
		}

        return $this->render('app/user/register.html.twig', array(
            //'error' => $error,
            //"last_username"=> $lastUsername
            "form" => $form->createView(),
        ));
        //return $this->render("AppBundle:user:login.html.twig");
    }


    public function sendEmailRegister($email)
    {

        //exit();

       // if(!empty($email))
       // {
            $token = str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid());


            $this_is = 'this is';
            $the_message = ' the message of the email';
            $mailer = $this->get('mailer');

            $message = \Swift_Message::newInstance()
                ->setSubject('The Subject for this Message')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo('any_account_name@any_domain.whatever')
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'app/emails/registration.html.twig',
                        array('token' => $token)
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

        
    }

    public function getRedirect()
    {
        
    }
}
