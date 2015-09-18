<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Entity\TourImage;
use Ghyneck\MapBundle\Form\TourImageType;

/**
 * Tour controller.
 *
 */
class TourImageController extends Controller
{

    /**
     * Lists all Tour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MapBundle:TourImage')->findAll();

        return $this->render('MapBundle:TourImage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Tour entity.
     *
     */
    public function createAction(Request $request)
    {
        $tourImage = new TourImage();
        $form = $this->createCreateForm($tourImage);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tourImage);
            $em->flush();

            return $this->redirect($this->generateUrl('tourimage_show', array('id' => $tourImage->getId())));
        }

        return $this->render('MapBundle:TourImage:new.html.twig', array(
            'entity' => $tourImage,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TourImage entity.
     *
     * @param TourImage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TourImage $entity)
    {        
        $form = $this->createForm(new TourImageType(), $entity, array(
            'action' => $this->generateUrl('tour_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TourImage entity.
     *
     */
    public function newAction()
    {
        $entity = new TourImage();
        $form   = $this->createCreateForm($entity);

        return $this->render('MapBundle:TourImage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TourImage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:TourImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TourImage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MapBundle:TourImage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TourImage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:TourImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TourImage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MapBundle:TourImage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TourImage entity.
    *
    * @param TourImage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TourImage $entity)
    {
        $form = $this->createForm(new TourImageType(), $entity, array(
            'action' => $this->generateUrl('tour_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TourImage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:TourImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TourImage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tour_edit', array('id' => $id)));
        }

        return $this->render('MapBundle:TourImage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TourImage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MapBundle:TourImage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TourImage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tour'));
    }

    /**
     * Creates a form to delete a TourImage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tour_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
