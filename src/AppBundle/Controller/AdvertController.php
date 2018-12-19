<?php

namespace AppBundle\Controller;

use Ramsey\Uuid\Uuid;
use AppBundle\Entity\Advert;
use AppBundle\Form\AdvertType;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Advert controller.
 *
 * @Route("api")
 */
class AdvertController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return the adverts"
     * )
     * @Rest\Get(
     *    path= "/adverts/"
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
            $advertsFormatted[$k]['uuid'] = $advert->getUuid();
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
     * @SWG\Response(
     *     response=201,
     *     description="Create a new advert"
     * )
     * @Rest\Post(
     *     path= "/advert"
     * )
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     */
    public function newAction(Request $request)
    {
        $advert = new Advert();
        $advert->setUser($this->getUser());
        $uuid = Uuid::uuid1();
        $advert->setUuid($uuid);

        $form = $this->createForm(AdvertType::class, $advert);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush($advert);

            $advertFormatted['id'] = $advert->getId();
            $advertFormatted['title'] = $advert->getTitle();
            $advertFormatted['description'] = $advert->getDescription();
            $advertFormatted['created_at'] = $advert->getCreatedAt();
            $advertFormatted['user']['id'] = $advert->getUser()->getId();
            $advertFormatted['user']['email'] = $advert->getUser()->getEmail();
            $advertFormatted['user']['firstname'] = $advert->getUser()->getFirstname();
            $advertFormatted['user']['lastname'] = $advert->getUser()->getLastname();

            $view = $this->view(["advert" => $advertFormatted], 201);
        }else{
            $view = $this->view($form->getErrors(true), 400);
        }
        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return the specific advert"
     * )
     * @Rest\Get(
     *    path= "/advert/{uuid}"
     * )
     */
    public function showAction($uuid)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('AppBundle:Advert')->findOneBy(["uuid" => $uuid]);

        $advertFormatted['id'] = $advert->getId();
        $advertFormatted['title'] = $advert->getTitle();
        $advertFormatted['description'] = $advert->getDescription();
        $advertFormatted['created_at'] = $advert->getCreatedAt();
        $advertFormatted['user']['id'] = $advert->getUser()->getId();
        $advertFormatted['user']['email'] = $advert->getUser()->getEmail();
        $advertFormatted['user']['firstname'] = $advert->getUser()->getFirstname();
        $advertFormatted['user']['lastname'] = $advert->getUser()->getLastname();

        $view = $this->view(["advert" => $advertFormatted], 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/{uuid}/edit", name="api_advert_edit")
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

//    /**
//     * Deletes a advert entity.
//     *
//     * @Route("/{id}", name="api_advert_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, Advert $advert)
//    {
//        $form = $this->createDeleteForm($advert);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($advert);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('api_advert_index');
//    }
//
////    /**
////     * Creates a form to delete a advert entity.
////     *
////     * @param Advert $advert The advert entity
////     *
////     * @return \Symfony\Component\Form\Form The form
////     */
////    private function createDeleteForm(Advert $advert)
////    {
////        return $this->createFormBuilder()
////            ->setAction($this->generateUrl('api_advert_delete', array('id' => $advert->getId())))
////            ->setMethod('DELETE')
////            ->getForm()
////        ;
////    }
}
