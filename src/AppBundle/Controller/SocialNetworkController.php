<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\SocialNetwork;
use AppBundle\Form\SocialNetworkType;

/**
 * SocialNetwork controller.
 *
 */
class SocialNetworkController extends Controller
{
    /**
     * Lists all SocialNetwork entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $socialNetworks = $em->getRepository('AppBundle:SocialNetwork')->findAll();

        return $this->render('socialnetwork/index.html.twig', array(
            'socialNetworks' => $socialNetworks,
        ));
    }

    /**
     * Creates a new SocialNetwork entity.
     *
     */
    public function newAction(Request $request)
    {
        $socialNetwork = new SocialNetwork();
        $form = $this->createForm('AppBundle\Form\SocialNetworkType', $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($socialNetwork);
            $em->flush();

            return $this->redirectToRoute('socialnetwork_show', array('id' => $socialNetwork->getId()));
        }

        return $this->render('socialnetwork/new.html.twig', array(
            'socialNetwork' => $socialNetwork,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SocialNetwork entity.
     *
     */
    public function showAction(SocialNetwork $socialNetwork)
    {
        $deleteForm = $this->createDeleteForm($socialNetwork);

        return $this->render('socialnetwork/show.html.twig', array(
            'socialNetwork' => $socialNetwork,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SocialNetwork entity.
     *
     */
    public function editAction(Request $request, SocialNetwork $socialNetwork)
    {
        $deleteForm = $this->createDeleteForm($socialNetwork);
        $editForm = $this->createForm('AppBundle\Form\SocialNetworkType', $socialNetwork);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($socialNetwork);
            $em->flush();

            return $this->redirectToRoute('socialnetwork_edit', array('id' => $socialNetwork->getId()));
        }

        return $this->render('socialnetwork/edit.html.twig', array(
            'socialNetwork' => $socialNetwork,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SocialNetwork entity.
     *
     */
    public function deleteAction(Request $request, SocialNetwork $socialNetwork)
    {
        $form = $this->createDeleteForm($socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($socialNetwork);
            $em->flush();
        }

        return $this->redirectToRoute('socialnetwork_index');
    }

    /**
     * Creates a form to delete a SocialNetwork entity.
     *
     * @param SocialNetwork $socialNetwork The SocialNetwork entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SocialNetwork $socialNetwork)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('socialnetwork_delete', array('id' => $socialNetwork->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
