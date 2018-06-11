<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\MedicalDetail;
use AppBundle\Form\MedicalDetailType;
use AppBundle\Entity\UserHasSpeciality;
/**
 * MedicalDetail controller.
 *
 */
class MedicalDetailController extends Controller
{
    /**
     * Lists all MedicalDetail entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        //echo count($oMedical);
        if(count($oMedical) == 0)
        {
            return $this->redirectToRoute('medicaldetail_new');
        }else{
            return $this->redirectToRoute('medicaldetail_edit', array('id' => $oMedical->getMdId()));
        }
        return $this->render('app/medicaldetail/index.html.twig', array(
            //'medicalDetails' => $medicalDetails,
        ));
    }

    public function checkData()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        //echo count($oMedical);
        if(count($oMedical) == 0)
        {
            return $this->redirectToRoute('medicaldetail_new');
        }else{
            return $this->redirectToRoute('medicaldetail_edit', array('id' => $oMedical->getMdId()));
        }
    }

    /**
     * Creates a new MedicalDetail entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        //echo count($oMedical);
        if(count($oMedical) != 0)
        {
            return $this->redirectToRoute('medicaldetail_edit', array('id' => $oMedical->getMdId()));
        }
        $medicalDetail = new MedicalDetail();
        $form = $this->createForm('AppBundle\Form\MedicalDetailType', $medicalDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $specialities = $form['extraSpeciality']->getData();
            //$this->setSpecialities($specialities);
            if( count($specialities) > 0)
            {
                $q = $em->createQuery("DELETE FROM AppBundle\Entity\UserHasSpeciality tb WHERE tb.usr=".$userId);
                $q->execute();
                $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrId"=> $userId) );

                foreach( $specialities as $value )
                {
                    $uhs = new UserHasSpeciality();
                    $uhs->setUsr($oUser);

                    $oSp = $em->getRepository('AppBundle:Speciality')->findOneBy( array("spId"=> $value->getSpId()) );
                    $uhs->setSp($oSp);

                    $em->persist($uhs);
                    $flush = $em->flush();
                    if( $flush == null )
                    {
                        //echo 1;
                    }
                }
            }

            /*
                // Recogemos el fichero
                $file=$form['mdProfileImage']->getData();
                if( $file != "")
                {
                    // Sacamos la extensión del fichero
                    $ext=$file->guessExtension();
                    // Le ponemos un nombre al fichero
                    $file_name=time().".".$ext;
                    // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                    $file->move("uploads", $file_name);
                    // Establecemos el nombre de fichero en el atributo de la entidad
                    $medicalDetail->setMdProfileImage($file_name);
                }
            */
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array( "usrId"=> $userId) );
            $medicalDetail->setUsr($oUser);

            $em->persist($medicalDetail);
            $em->flush();

            return $this->redirectToRoute('medicaldetail_edit', array('id' => $medicalDetail->getMdId()));
        }

        return $this->render('app/medicaldetail/new.html.twig', array(
            'medicalDetail' => $medicalDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MedicalDetail entity.
     *
     */
    public function showAction(MedicalDetail $medicalDetail)
    {
        $deleteForm = $this->createDeleteForm($medicalDetail);

        return $this->render('app/medicaldetail/show.html.twig', array(
            'medicalDetail' => $medicalDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MedicalDetail entity.
     *
     */
    public function editAction(Request $request, MedicalDetail $medicalDetail)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $id = $request->get("id");
        $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        if( count($oMedical) == 1 )
        {
            if( $oMedical->getMdId() != $id)
            {
                return $this->redirectToRoute('medicaldetail_edit', array('id' => $oMedical->getMdId()));
            }
        }else{
            return $this->redirectToRoute('medicaldetail_new');
        }

        /*
            $currentImage = "";
            $oCurrentImage = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "mdId"=> $id) );

            if($oCurrentImage){
                if( $oCurrentImage->getMdProfileImage() )
                {
                    $currentImage = $oCurrentImage->getMdProfileImage();
                }
            }
        */


        $deleteForm = $this->createDeleteForm($medicalDetail);
        $editForm = $this->createForm('AppBundle\Form\MedicalDetailType', $medicalDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $specialities = $editForm['extraSpeciality']->getData();

                $q = $em->createQuery("DELETE FROM AppBundle\Entity\UserHasSpeciality tb WHERE tb.usr=".$userId);
                $q->execute();
                $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrId"=> $userId) );
                if( count($specialities) > 0)
                {
                    foreach( $specialities as $value )
                    {
                        $uhs = new UserHasSpeciality();
                        $uhs->setUsr($oUser);

                        $oSp = $em->getRepository('AppBundle:Speciality')->findOneBy( array("spId"=> $value->getSpId()) );
                        $uhs->setSp($oSp);

                        $em->persist($uhs);
                        $flush = $em->flush();
                        if( $flush == null )
                        {
                            //echo 1;
                        }
                    }
                }
            
            /*    
                // Recogemos el fichero
                $file=$editForm['mdProfileImage']->getData();
                if( $file != "")
                {
                    // Sacamos la extensión del fichero
                    $ext=$file->guessExtension();
                    // Le ponemos un nombre al fichero
                    $file_name=time().".".$ext;
                    // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                    $file->move("uploads", $file_name);
                    // Establecemos el nombre de fichero en el atributo de la entidad
                    $medicalDetail->setMdProfileImage($file_name);
                    @unlink( __DIR__.'/../../../web/uploads/'.$currentImage);
                }else{
                    $medicalDetail->setMdProfileImage($currentImage);
                }
            */
            $em->persist($medicalDetail);
            $em->flush();
            //exit();
            return $this->redirectToRoute('medicaldetail_edit', array('id' => $medicalDetail->getMdId()));
        }

        $ouserHasSpecialities = $em->getRepository('AppBundle:UserHasSpeciality')->findBy( array( "usr"=> $userId) );
        //$image_repo = $em->getRepository("AppBundle:MedicalDetailType")->findOneBy( array( "usr"=> $userId));
        // ( $this->getSpecialities() );
        //echo count($this->getSpecialities());
        //echo count($ouserHasSpecialities);
        return $this->render('app/medicaldetail/edit.html.twig', array(
            'medicalDetail' => $medicalDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            "currentSpecialities"=> $ouserHasSpecialities,
        ));
    }

    public function setSpecialities($specialities)
    {
        $data = explode(",", $specialities);

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $q = $em->createQuery('delete from AppBundle\Entity\Speciality tb where tb.usr = '.$userId);
        $numDeleted = $q->execute();

        for($i=0; $i < count($data); $i++)
        {
            $sp = new \AppBundle\Entity\Speciality();
            $sp->setSpName( $data[$i] );
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array("usrId"=> $userId) );
            $sp->setUsr($oUser);
            $sp->setSpCreated(new \DateTime());
            $em->persist($sp);
            $flush = $em->flush();
        }
    }

    public function getSpecialities()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oSpecialities = $em->getRepository('AppBundle:Speciality')->findBy( array("usr"=> $userId) );
        $arr = array();
        foreach( $oSpecialities as $sp)
        {
            $arr[] = $sp->getSpName();
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function profileImageAction(Request $request, $max = null, $iClass = null)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oInfo = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        $image = "";
        if( $oInfo &&  $oInfo->getMdProfileImage() != "")
        {
            $image = $oInfo->getMdProfileImage();
        }

        return $this->render('app/medicaldetail/profileImage.html.twig', array("image"=>$image,"max"=>$max,"iClass"=>$iClass));

    }

    /**
     * Deletes a MedicalDetail entity.
     *
     */
    public function deleteAction(Request $request, MedicalDetail $medicalDetail)
    {
        $form = $this->createDeleteForm($medicalDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $image = $medicalDetail->getMdProfileImage();
            @unlink( __DIR__.'/../../../web/uploads/'.$image);
            $em->remove($medicalDetail);
            $em->flush();
        }

        return $this->redirectToRoute('medicaldetail_index');
    }

    /**
     * Creates a form to delete a MedicalDetail entity.
     *
     * @param MedicalDetail $medicalDetail The MedicalDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MedicalDetail $medicalDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicaldetail_delete', array('id' => $medicalDetail->getMdId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
