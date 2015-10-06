<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MapBundle:Category')->findAll();

        return $this->render('MapBundle:Category:index.html.twig', array(
            'entities' => $entities,
        ));    }

    public function createAction()
    {
        return $this->render('MapBundle:Category:create.html.twig', array(
                // ...
            ));    }

    public function newAction()
    {
        return $this->render('MapBundle:Category:new.html.twig', array(
                // ...
            ));    }

    public function showAction()
    {
        return $this->render('MapBundle:Category:show.html.twig', array(
                // ...
            ));    }

    public function editAction()
    {
        return $this->render('MapBundle:Category:edit.html.twig', array(
                // ...
            ));    }

    public function updateAction()
    {
        return $this->render('MapBundle:Category:update.html.twig', array(
                // ...
            ));    }

    public function deleteAction()
    {
        return $this->render('MapBundle:Category:delete.html.twig', array(
                // ...
            ));    }

}
