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
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        if (!$adverts) {
            return $this->view(['adverts' => 'not exist'], 200);
        }

        $advertsFormatted = [];
        foreach($adverts as $k => $advert){
            $advertsFormatted[$k]['id'] = $advert->getId();
            $advertsFormatted[$k]['uuid'] = $advert->getUuid();
            $advertsFormatted[$k]['category']['label'] = $advert->getCategory()->getLabel();
            foreach($advert->getCategory()->getFields() as $v => $field){
                $advertsFormatted[$k]['category']['fields'][$v] = $field->getName();
            }
            $advertsFormatted[$k]['title'] = $advert->getTitle();
            $advertsFormatted[$k]['description'] = $advert->getDescription();
            $advertsFormatted[$k]['created_at'] = $advert->getCreatedAt();
            $advertsFormatted[$k]['user']['id'] = $advert->getUser()->getId();
            $advertsFormatted[$k]['user']['email'] = $advert->getUser()->getEmail();
            $advertsFormatted[$k]['user']['firstname'] = $advert->getUser()->getFirstname();
            $advertsFormatted[$k]['user']['lastname'] = $advert->getUser()->getLastname();
        }

        $view = $this->view(["adverts" => $advertsFormatted, "categories" => $categories], 200);

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
            $em->flush();

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
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        if(!$advert){
            $view = $this->view(["advert" => "Not exist"], 404);
        }

        $advertFormatted['id'] = $advert->getId();
        $advertFormatted['uuid'] = $advert->getUuid();
        $advertFormatted['category']['label'] = $advert->getCategory()->getLabel();
        foreach($advert->getCategory()->getFields() as $v => $field){
            $advertFormatted['category']['fields'][$v] = $field->getName();
        }
        $advertFormatted['title'] = $advert->getTitle();
        $advertFormatted['description'] = $advert->getDescription();
        $advertFormatted['created_at'] = $advert->getCreatedAt();
        $advertFormatted['user']['id'] = $advert->getUser()->getId();
        $advertFormatted['user']['email'] = $advert->getUser()->getEmail();
        $advertFormatted['user']['firstname'] = $advert->getUser()->getFirstname();
        $advertFormatted['user']['lastname'] = $advert->getUser()->getLastname();

        $view = $this->view(["advert" => $advertFormatted, "categories" => $categories], 200);

        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Edit the specific advert"
     * )
     * @Rest\Put(
     *    path= "/advert/{uuid}"
     * )
     */
    public function editAction(Request $request, $uuid)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('AppBundle:Advert')->findOneBy(["uuid" => $uuid]);

        $formEdit = $this->createForm('AppBundle\Form\AdvertType', $advert);
        $formEdit->submit($request->request->all());

        if ($formEdit->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $view = $this->view(["advert" => $advert], 200);
        }else{
            $view = $this->view($formEdit->getErrors(true), 400);
        }
        return $this->handleView($view);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Delete the specific advert"
     * )
     * @Rest\Delete(
     *    path= "/advert/{uuid}"
     * )
     */
    public function deleteAction($uuid)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('AppBundle:Advert')->findOneBy(["uuid" => $uuid]);

        if(!$advert){
            $view = $this->view(["advert" => "Advert not exist", "status"=>"400"], 400);
        }else{
            $em->remove($advert);
            $em->flush();

            $view = $this->view(["message" => "Advert deleted", "status"=>"204"], 204);
        }
        return $this->handleView($view);


    }
}
