<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * MedicalDetail controller.
 *
 */
class SetProfileImageController extends Controller
{
    /**
     * Lists all MedicalDetail entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        //$oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );

        return $this->render('app/setProfileImage/index.html.twig', array(
            //'medicalDetails' => $medicalDetails,
        ));
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
