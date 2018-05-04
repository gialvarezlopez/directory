<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Pricing;
use AppBundle\Form\PricingType;

/**
 * Pricing controller.
 *
 */
class PricingController extends Controller
{
    /**
     * Lists all Pricing entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pricings = $em->getRepository('AppBundle:Pricing')->findAll();

        return $this->render('pricing/index.html.twig', array(
            'pricings' => $pricings,
        ));
    }

    /**
     * Creates a new Pricing entity.
     *
     */
    public function newAction(Request $request)
    {
        $pricing = new Pricing();
        $form = $this->createForm('AppBundle\Form\PricingType', $pricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricing);
            $em->flush();

            return $this->redirectToRoute('pricing_show', array('id' => $pricing->getId()));
        }

        return $this->render('pricing/new.html.twig', array(
            'pricing' => $pricing,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pricing entity.
     *
     */
    public function showAction(Pricing $pricing)
    {
        $deleteForm = $this->createDeleteForm($pricing);

        return $this->render('pricing/show.html.twig', array(
            'pricing' => $pricing,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pricing entity.
     *
     */
    public function editAction(Request $request, Pricing $pricing)
    {
        $deleteForm = $this->createDeleteForm($pricing);
        $editForm = $this->createForm('AppBundle\Form\PricingType', $pricing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricing);
            $em->flush();

            return $this->redirectToRoute('pricing_edit', array('id' => $pricing->getId()));
        }

        return $this->render('pricing/edit.html.twig', array(
            'pricing' => $pricing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pricing entity.
     *
     */
    public function deleteAction(Request $request, Pricing $pricing)
    {
        $form = $this->createDeleteForm($pricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pricing);
            $em->flush();
        }

        return $this->redirectToRoute('pricing_index');
    }

    /**
     * Creates a form to delete a Pricing entity.
     *
     * @param Pricing $pricing The Pricing entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pricing $pricing)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pricing_delete', array('id' => $pricing->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
