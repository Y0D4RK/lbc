<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advert;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Advert controller.
 *
 * @Route("api/advert")
 */
class AdvertController extends FOSRestController
{

    /**
     * @Route("/", name="api_advert_index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the adverts"
     * )
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adverts = $em->getRepository('AppBundle:Advert')->findAll();

        if (empty($adverts)) {
            return $this->view(['adverts' => 'not exist'], 200);
        }

        $advertsFormatted = [];
        foreach($adverts as $k => $advert){
            $advertsFormatted[$k]['id'] = $advert->getId();
            $advertsFormatted[$k]['title'] = $advert->getTitle();
            $advertsFormatted[$k]['description'] = $advert->getDescription();
            $advertsFormatted[$k]['created_at'] = $advert->getCreatedAt();
            $advertsFormatted[$k]['user']['id'] = $advert->getUser()->getId();
            $advertsFormatted[$k]['user']['email'] = $advert->getUser()->getEmail();
            $advertsFormatted[$k]['user']['firstname'] = $advert->getUser()->getFirstname();
            $advertsFormatted[$k]['user']['lastname'] = $advert->getUser()->getLastname();
        }

        $view = $this->view(["adverts" => $advertsFormatted], 200);

        return $this->handleView($view);
    }

    /**
     * Creates a new advert entity.
     *
     * @Route("/new", name="api_advert_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $advert = new Advert();
        $form = $this->createForm('AppBundle\Form\AdvertType', $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            return $this->redirectToRoute('api_advert_show', array('id' => $advert->getId()));
        }

        return $this->render('advert/new.html.twig', array(
            'advert' => $advert,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a advert entity.
     *
     * @Route("/{id}", name="api_advert_show")
     * @Method("GET")
     */
    public function showAction(Advert $advert)
    {
        $deleteForm = $this->createDeleteForm($advert);

        return $this->render('advert/show.html.twig', array(
            'advert' => $advert,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing advert entity.
     *
     * @Route("/{id}/edit", name="api_advert_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Advert $advert)
    {
        $deleteForm = $this->createDeleteForm($advert);
        $editForm = $this->createForm('AppBundle\Form\AdvertType', $advert);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('api_advert_edit', array('id' => $advert->getId()));
        }

        return $this->render('advert/edit.html.twig', array(
            'advert' => $advert,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a advert entity.
     *
     * @Route("/{id}", name="api_advert_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Advert $advert)
    {
        $form = $this->createDeleteForm($advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($advert);
            $em->flush();
        }

        return $this->redirectToRoute('api_advert_index');
    }

    /**
     * Creates a form to delete a advert entity.
     *
     * @param Advert $advert The advert entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Advert $advert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('api_advert_delete', array('id' => $advert->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
