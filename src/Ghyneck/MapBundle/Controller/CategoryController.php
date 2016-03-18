<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ghyneck\MapBundle\Entity\Category;
use Ghyneck\MapBundle\Form\CategoryType;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MapBundle:Category')->findAll();

        return $this->render('MapBundle:Category:index.html.twig', array(
            'entities' => $entities,
        ));    }

    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createCreateForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('id' => $category->getId())));
        }

        return $this->render('MapBundle:Category:create.html.twig', array(
            'entity' => $category,
            'form'   => $form->createView(),
            ));
    }

    /**
     * Creates a form to create a Tour entity.
     *
     * @param Tour $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function newAction()
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);

        return $this->render('MapBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
