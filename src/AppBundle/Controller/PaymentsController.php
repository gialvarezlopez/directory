<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PaymentsController extends Controller
{

    private $session;
	
	public function __construct() {
		$this->session = new Session();
	}

    public function reviewAction(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();
        //$userId = $this->getUser()->getUsrId();
        //$galleries = $em->getRepository('AppBundle:Payer')->findBy( array("usr"=> $userId) );

        /*
        $result = $this->getPayer();
        if( count( $result) >0 ){
            //already exits a record

            //Is pending to pay
            if( $result["days"] != 1 )
            {
                $urlPay = $this->generateUrl('payments_checkIn');
                return $this->redirect($urlPay);
            }
            else
            {

                $url = $this->generateUrl('payments_checkIn' );
                return $this->redirect($url);
                exit();
            }
        }else{
            $urlPay = $this->generateUrl('payments_checkIn');
            return $this->redirect($urlPay);
        }
        */
        $url = $this->generateUrl('payments_checkIn' );
        return $this->redirect($url);
        exit();
    }

    public function getPayer()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
		$RAW_QUERY = "SELECT pay_deadline, pay_created FROM payer p WHERE p.usr_id =:userId AND pay_deadline >= NOW() ORDER BY pay_id ";
		$statement = $em->getConnection()->prepare($RAW_QUERY);
		$statement->bindValue("userId", $userId);
        $statement->execute();
        $result = $statement->fetchAll();
        $restingDays = 0;
        for($i =0; $i < count($result); $i++)
        {
            $created =  $result[$i]['pay_created'];
            $deadline =  $result[$i]['pay_deadline'];
            $res = $this->restingDays($created, $deadline);
            $restingDays = $restingDays + $res;
        }
        //dump($result);
        //exit();

        return array("licences"=>count($result), "days"=> $restingDays );
    }

    public function restingDays($created, $deadline){
        $deadline = $deadline; //$result[0]['pay_deadline'];
        $created = date('Y-m-d',strtotime($created)); 
        $s = strtotime($deadline)-strtotime($created);  
        $d = intval($s/86400);  
        $diferencia = $d;
        
        return ( $diferencia > 0 )?$diferencia:0;
    }

    public function checkInAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $processors = $em->getRepository('AppBundle:PaymentProcessor')->findBy( array("ppActive"=> 1) );

        $pricing = $em->getRepository('AppBundle:Pricing')->findBy( array("prActive"=> 1) );

        $result = $this->getPayer();
        //$deadline = $result[0]['pay_deadline'];
        //$created = date('Y-m-d',strtotime($result[0]['pay_created']));

        $pendingDays = $result;

        //check if the user already has a free account
        $oFreeAccount = $em->getRepository('AppBundle:Payer')->findBy( array("usr"=> $userId, "payActive"=>1, "pp"=>null) );
        $hasFreeAccount = count($oFreeAccount);

        return $this->render('app/payments/checkIn.html.twig', array(
            "processors"=> $processors,
            "pricing" => $pricing,
            "pendingDays" =>$pendingDays,
            "hasFreeAccount"=>$hasFreeAccount,
        ));
    }

    public function msgBoxPayAction(Request $request)
    {
        $result = $this->getPayer();
        $pendingDays = $result;
        return $this->render('app/payments/msgBoxPay.html.twig',array("pendingDays"=>$pendingDays));        
    }

    public function infoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();

        //$currentPays = $em->getRepository('AppBundle:Payer')->findBy( array("usr"=> $userId) );
        $pays = $em->getRepository('AppBundle:Payer')->findBy( array("usr"=> $userId,"payActive"=>1), array('payId' => 'DESC') );
        return $this->render('app/payments/info.html.twig', array( "pays"=>$pays) );

    }

    public function validationAction(Request $request)
    {
        $userId = $this->getUser()->getUsrId();
        if( $userId )
        {
            $id_payment_gateway = $request->query->get("payment_gateway"); //GET
            $id_pricing = $request->query->get("pricing");
            //$id = $request->get("payment_gateway"); //POST

            if( (!is_numeric($id_payment_gateway) || !is_numeric($id_pricing) ) && $id_payment_gateway != "free" )
            {
                throw new AccessDeniedException("Invalid parameters!");
            }
            else
            {
                $em = $this->getDoctrine()->getManager();
                $oPricing = $em->getRepository('AppBundle:Pricing')->findOneBy( array("prActive"=> 1, "prId"=>$id_pricing) );

                if(!$oPricing)
                {
                    throw new AccessDeniedException("Invalid plan method!");
                }

                if( $id_payment_gateway == "free" )
                {
                    $oPaymentProcessor = $id_payment_gateway;
                    $res = $this->paymentStart($oPaymentProcessor, $oPricing);
                    if( $res == 1 )
                    {
                        $msg = "Thank you, the user has been published on the website successfully, you have a free month";
                        $this->session->getFlashBag()->add("success", $msg);
                        return $this->redirectToRoute('payments_info');
                    }else{
                        throw new AccessDeniedException("There was an error!");
                    }
                }
                else
                {
                    $oPaymentProcessor = $em->getRepository('AppBundle:PaymentProcessor')->findOneBy( array("ppActive"=> 1, "ppId"=>$id_payment_gateway) );
                    if(!$oPaymentProcessor)
                    {
                        throw new AccessDeniedException("Invalid Payment Gateway!");
                    }

                    if( $oPaymentProcessor->getPpKey() == "" || empty($oPaymentProcessor->getPpKey()) )
                    {
                        throw new AccessDeniedException("The key of payment gateway is missing!");
                    }

                    $this->paymentStart($oPaymentProcessor, $oPricing);
                }    
                
            }

            
            exit();
        }
        else
        {
            throw new AccessDeniedException("You don't have access to this page, please login or register!");
        }
    }

    //==================================================
    //Payment to save data
    //==================================================
    public function paymentStart( $oPaymentProcessor, $oPricing ){
		$session = new Session();
        
		if( (is_object($oPaymentProcessor) || $oPaymentProcessor == "free" ) && is_object($oPricing) )
		{	
            if( $oPaymentProcessor == "free" ){
                $type = $oPaymentProcessor;
            }
            else{
                $type = strtolower($oPaymentProcessor->getPpKey());
            }
            $userId = $this->getUser()->getUsrId();
            switch( $type )
            {
                case "paypal":
                        $is_checkout = "checkout";
                        $paypal = $this->get('srv_Paypal');
                        $session->set('paid', 1);
                        $aData = $this->getGeneralParameters();
                        $paypal->setParameterDB($aData['nameDB'], $aData['hostDB'], $aData['userDB'], $aData['passwordDB'], $aData['portDB'], $aData['urlSuccess'], $aData['urlCancel'] );
                        $planId = $oPricing->getPrId(); 
                        $months = $oPricing->getPrMonths(); 
                        $paymentProcessorId = $oPaymentProcessor->getPpId();
                        $session->set("paymentProcessorName", "paypal");
                        $paypal->processPaypal($userId, $planId, $months, $paymentProcessorId, $is_checkout );
                    break;
                case "free":
                        $months = $oPricing->getPrMonths(); 
                        $paymentProcessorId = "free";
                        return $this->freePaymentAccount($userId, $oPricing, $months, $paymentProcessorId );
                        //echo "antes - ";
                        //return $this->redirectToRoute('payments_paymentSuccess');
                    break;    
                default:
                    throw new AccessDeniedException("Error the payment is unknown!");
                    break;
			}
		
		}
		else{
			return $this->redirectToRoute("payments_info");
		}
		
		exit();
    }
    
    /*
        private function savePayData( $oPaymentProcessor, $oPricing )
        {
            if( is_object($oPaymentProcessor) && is_object($oPricing) )
            {
                $em = $this->getDoctrine()->getManager();

                $userId = $this->getUser()->getUsrId();
                $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrActive"=> 1, "usrId"=>$userId) );
                $pay = new Payer();
                $pay->setUsr( $oUser );
                $pay->setPp($oPaymentProcessor );
                $pay->setPr($oPricing);
                $pay->setMoneyPaid( sprintf( '%0.2f', $oPricing->getPrPrice() ) );
                $pay->setCreated( new \datetime() );
                $flush = $em->flush();
                if ($flush == null)
                {
                    return true;
                }else{
                    throw new AccessDeniedException("There was an error trying to save the data!");
                }
            }
            return false;
        }
    */

    public function freePaymentAccount( $userId, $oPricing, $months, $paymentProcessorId )
    {
        $em = $this->getDoctrine()->getManager();
        $payer = new \AppBundle\Entity\Payer();
                    
        
        $oUser = $em->getRepository('AppBundle:User')->findOneBy( array( "usrId"=> $userId) );
        $payer->setUsr($oUser);

        $payer->setPr($oPricing);

        $payer->setPayMoneyPaid($oPricing->getPrPrice());

        $date = date('Y-m-d H:i:s');
        $months = $months;
		$newDate = strtotime ( "+".$months." month" , strtotime ( $date ) ) ;
        $deadLine = date ( 'Y-m-d H:i:s' , $newDate );
        
        $payer->setPayDeadLine( new \DateTime($deadLine) );
        $payer->setPayCreated( new \DateTime($date) );
        $payer->setPayActive(1);
        $payer->setPayIsPaid(1);

        $em->persist($payer);			
        $flush = $em->flush();
        if( $flush == null)
        {
            return 1;
        }
        //return $this->redirectToRoute('payments_info');
    }

    public function paymentSuccessAction( Request $request )
	{
		$session = new Session();
		$token = $request->query->get('token');
		$PayerID = $request->query->get('PayerID');
		
		if( isset($token) ){

            switch( $session->get("paymentProcessorName") )
            {
                case "paypal":
                    $paypal = $this->get('srv_Paypal');			
                    $aData = $this->getGeneralParameters();
                    $paypal->setParameterDB($aData['nameDB'], $aData['hostDB'], $aData['userDB'], $aData['passwordDB'], $aData['portDB'], $aData['urlSuccess'], $aData['urlCancel'] );
                    $paypal->viewTransactionPaypal($token, $PayerID);
                break;
            }
			
			
			$sessionUser =  $session->get("paid");

			if( $sessionUser)
			{
				$session->remove('paid');
				$msg = "Transaction was created successfully";
				$this->session->getFlashBag()->add("success", $msg);
				return $this->redirectToRoute('payments_info');
			}
			else
			{
				exit("Ocurred an error");
			}
		}
		else
		{
			throw new \Exception('Something went wrong!');
		}
	}

    public function paymentCancelAction( Request $request )
	{
		
    }

    public function getGeneralParameters()
	{
		$urlSuccess = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']. $this->generateUrl('payments_paymentSuccess');
		$urlCancel = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$this->generateUrl('payments_review');
		
		$em = $this->getDoctrine()->getEntityManager();
		$nameDB = $em->getConnection()->getDatabase();
		$hostDB = $em->getConnection()->getHost();
		$userDB = $em->getConnection()->getUsername();
		$passwordDB = $em->getConnection()->getPassword();
		$portDB = $em->getConnection()->getPort();
		
		return array( "urlSuccess"=>$urlSuccess, "urlCancel"=>$urlCancel, "nameDB"=>$nameDB, "hostDB"=>$hostDB, "userDB"=>$userDB, "passwordDB"=>$passwordDB, "portDB"=>$portDB );
	}
}
