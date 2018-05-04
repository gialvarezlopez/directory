<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\MedicalDetail;
use AppBundle\Form\MedicalDetailType;

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
        return $this->render('medicaldetail/index.html.twig', array(
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
            $this->setSpecialities($specialities);

            // Recogemos el fichero
            $file=$form['mdProfileImage']->getData();
            // Sacamos la extensión del fichero
            $ext=$file->guessExtension();
            // Le ponemos un nombre al fichero
            $file_name=time().".".$ext;
            // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
            $file->move("uploads", $file_name);
            // Establecemos el nombre de fichero en el atributo de la entidad
            $medicalDetail->setMdProfileImage($file_name);
            $oUser = $em->getRepository('AppBundle:User')->findOneBy( array( "usrId"=> $userId) );
            $medicalDetail->setUsr($oUser);    

            $em->persist($medicalDetail);
            $em->flush();

            return $this->redirectToRoute('medicaldetail_edit', array('id' => $medicalDetail->getMdId()));
        }

        return $this->render('medicaldetail/new.html.twig', array(
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

        return $this->render('medicaldetail/show.html.twig', array(
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
        
       

        $deleteForm = $this->createDeleteForm($medicalDetail);
        $editForm = $this->createForm('AppBundle\Form\MedicalDetailType', $medicalDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $specialities = $editForm['extraSpeciality']->getData();
            $this->setSpecialities($specialities);

            // Recogemos el fichero
            $file=$editForm['mdProfileImage']->getData();
            if( $file )
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
             

            $em->persist($medicalDetail);
            $em->flush();

            return $this->redirectToRoute('medicaldetail_edit', array('id' => $medicalDetail->getMdId()));
        }

        //$image_repo = $em->getRepository("AppBundle:MedicalDetailType")->findOneBy( array( "usr"=> $userId));
        // ( $this->getSpecialities() );
        return $this->render('medicaldetail/edit.html.twig', array(
            'medicalDetail' => $medicalDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            "specialities"=> $this->getSpecialities(),
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
