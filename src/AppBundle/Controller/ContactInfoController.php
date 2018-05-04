<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

 
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use AppBundle\Entity\ContactInfo;
use AppBundle\Entity\City;
//use AppBundle\Entity\UserHasSocialNetWork;
use AppBundle\Form\ContactInfoType;
//use AppBundle\Form\UserHasSocialNetWork;

/**
 * ContactInfo controller.
 *
 */
class ContactInfoController extends Controller
{
    /**
     * Creates a new ContactInfo entity.
     *
     */
    public function indexAction(Request $request)
    {
        /*
            $contactInfo = new ContactInfo();
            $form = $this->createForm('AppBundle\Form\ContactInfoType', $contactInfo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contactInfo);
                $em->flush();

                return $this->redirectToRoute('contactinfo_show', array('id' => $contactInfo->getCouId()));
            }
        */

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();

        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $socialNetworks = $em->getRepository('AppBundle:SocialNetwork')->findBy( array("snActive"=>1) );

        $oContactInfo = $em->getRepository('AppBundle:ContactInfo')->findBy( array("usr"=>$userId) );
        $schedule = array();
        $country_selected = "";
        $state_selected = "";
        $city_selected = "";
        $dataStates = array();
        $dataCities = array();
        if( count($oContactInfo) > 0 )
        {
            $schedule = unserialize( $oContactInfo[0]->getCiSchedule() );

            $RAW_QUERY = "SELECT * from country c
                            INNER JOIN state s ON c.cou_id=s.cou_id
                            INNER JOIN city ct ON s.sta_id = ct.sta_id
                            WHERE ct.cit_id = ".$oContactInfo[0]->getCit()->getCitId();
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
            $data = $statement->fetchAll();

            $country_selected = $data[0]['cou_id'];
            $state_selected = $data[0]['sta_id'];
            $city_selected = $data[0]['cit_id'];

            //Get all states filted by country selected
            /*
                $RAW_QUERY = "SELECT * from state where cou_id = ".$country_selected;
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $dataStates = $statement->fetchAll();
            */
            $dataStates = $em->getRepository('AppBundle:State')->findBy( array("cou"=>$country_selected) );

            //get all cities from state selected
            /*
                $RAW_QUERY = "SELECT * from city where sta_id = ".$state_selected;
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $dataCities = $statement->fetchAll();
            */
            $dataCities = $em->getRepository('AppBundle:City')->findBy( array("sta"=>$state_selected) );
        }
        else
        {
            $oContactInfo[0]["ciAddress"] = "";
            $oContactInfo[0]['ciPhone1'] = "";
            $oContactInfo[0]['ciPhone2'] = "";
            $oContactInfo[0]['ciLat'] = "";
            $oContactInfo[0]['ciLng'] = "";
        }

        $networkSelected = $em->getRepository('AppBundle:UserHasSocialNetwork')->findBy( array("usr"=>$userId ) );
        /*
            $RAW_QUERY = "SELECT * FROM contact_info  WHERE usr_id = $userId ";
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
            $oUser = $statement->fetchAll();
        */

        //$em->getRepository('AppBundle:City')->findBy( array("usr"=>$userId ) );


        return $this->render('app/contactinfo/new.html.twig', array(
            //'contactInfo' => $contactInfo,
            //'form' => $form->createView(),
            'countries' => $countries,
            "states"=>$dataStates,
            "cities"=>$dataCities,
            'socialNetworks' => $socialNetworks,
            "schedule"=>$schedule,
            "networkSelected"=>$networkSelected,
            "contactInfo"=>$oContactInfo,
            "country_selected"=>$country_selected,
            "state_selected"=>$state_selected,
            "city_selected"=>$city_selected,
        ));
    }

    public function dropdownAction(Request $request)
    {
        $id = $request->get("id");
        $dropdown = $request->get("dropdown");
        if($request->isXmlHttpRequest())
        {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
    
            $serializer = new Serializer($normalizers, $encoders);
            $em = $this->getDoctrine()->getManager();

            switch( $dropdown ){
                case "state";
                    $posts = $em->getRepository('AppBundle:State')->findBy( array( "cou" => $id) );
                break;
                case "city";
                    $posts = $em->getRepository('AppBundle:City')->findBy( array( "sta" => $id) );
                break;
                default:
                    $posts = $em->getRepository('AppBundle:Country')->findAll();
                break;
            }
            
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                    'response' => 'success',
                    'posts' => $serializer->serialize($posts, 'json')
            ));
            return $response;
            //return $response = new JsonResponse($posts);
        }
    }

    public function saveDataContactInfoAction( Request $request ){
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $lat = $request->get("lat"); 
        $lng = $request->get("lng");
        $address = $request->get("address");
        $city = $request->get("city");
        $phone1 = $request->get("phone1");
        $phone2 = $request->get("phone2");
        $social_network = $request->get("social_network");
        $schedule = $request->get("schedule");  
       			      
        $em->getConnection()->beginTransaction(); // suspend auto-commit
		$status = 0;
		try
		{

            

            $info = $em->getRepository('AppBundle:ContactInfo')->findOneBy( array( "usr"=> $userId) );
            if( count($info) == 0 )
            {
                $info = new ContactInfo();
            }

            $info->setCiPhone1($phone1);
            $info->setCiPhone2($phone2);
            $info->setCiAddress($address);
            $info->setCiLat($lat);
            $info->setCiLng($lng);

            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array( "usrId"=> $userId) );
            $info->setUsr($oUser);
            
            $oCity = $em->getRepository('AppBundle:City')->findOneBy( array( "citId"=> $city) );
            $info->setCit($oCity);
            
            $schedule = json_decode($schedule, true);
            if( count($schedule) > 0 )
            {
                //$oClientUser[0]->setCliUsuDiasTrabajos(serialize($schedule) );
                $info->setCiSchedule( serialize($schedule) ); 
            }else{
                $info->setCiSchedule(""); 
                //$oClientUser[0]->setCliUsuDiasTrabajos("");
            }

            $em->persist($info);			
            $flush = $em->flush();
            
            $q = $em->createQuery('delete from AppBundle\Entity\UserHasSocialNetwork tb where tb.usr = '.$userId);
            $numDeleted = $q->execute();

            $social_network = json_decode($social_network, true);
            if( count($social_network) > 0 )
            {
                foreach( $social_network as $sn)
                {
                    
                    $network = new \AppBundle\Entity\UserHasSocialNetwork();
                    
                    $network->setUsr( $oUser );
                    $oSocialNetwork = $em->getRepository('AppBundle:SocialNetwork')->findOneBy( array("snId"=> $sn['id']) );
                    $network->setSn($oSocialNetwork);
                    $network->setUsnLink($sn['url']);
                    $em->persist($network);			
                    $flush = $em->flush();
                    
                }
            }

            $em->getConnection()->commit();
            echo 1;
        }
        catch (\Exception $e)
        {
            $em->getConnection()->rollBack();
            throw $e;
            //echo ($e->getMessage());
        }
        exit();
    }

    /**
     * Finds and displays a ContactInfo entity.
     *
     */
    /*
    public function showAction(ContactInfo $contactInfo)
    {
        $deleteForm = $this->createDeleteForm($contactInfo);

        return $this->render('contactinfo/show.html.twig', array(
            'contactInfo' => $contactInfo,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    */

    /**
     * Displays a form to edit an existing ContactInfo entity.
     *
     */
    public function editAction(Request $request, ContactInfo $contactInfo)
    {
        $deleteForm = $this->createDeleteForm($contactInfo);
        $editForm = $this->createForm('AppBundle\Form\ContactInfoType', $contactInfo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactInfo);
            $em->flush();

            return $this->redirectToRoute('contactinfo_edit', array('id' => $contactInfo->getCouId()));
        }

        return $this->render('app/contactinfo/edit.html.twig', array(
            'contactInfo' => $contactInfo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ContactInfo entity.
     *
     */
    public function deleteAction(Request $request, ContactInfo $contactInfo)
    {
        $form = $this->createDeleteForm($contactInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contactInfo);
            $em->flush();
        }

        return $this->redirectToRoute('contactinfo_index');
    }

    /**
     * Creates a form to delete a ContactInfo entity.
     *
     * @param ContactInfo $contactInfo The ContactInfo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ContactInfo $contactInfo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactinfo_delete', array('id' => $contactInfo->getCouId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
