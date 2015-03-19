<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Form\TourType;

/**
 * Tour controller.
 *
 */
class TourController extends Controller
{

    /**
     * Lists all Tour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MapBundle:Tour')->findAll();

        return $this->render('MapBundle:Tour:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Tour entity.
     *
     */
    public function createAction(Request $request)
    {
        $tour = new Tour();
        $form = $this->createCreateForm($tour);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tour->setMarkerlat(0.0);
            $tour->setMarkerlon(0.0);                                   
            $em = $this->getDoctrine()->getManager();
            $em->persist($tour);
            $gpxFile = $tour->getGpxFile();
            $em->persist($gpxFile);
            $em->flush();

            return $this->redirect($this->generateUrl('tour_show', array('id' => $tour->getId())));
        }

        return $this->render('MapBundle:Tour:new.html.twig', array(
            'entity' => $tour,
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
    private function createCreateForm(Tour $entity)
    {        
        $form = $this->createForm(new TourType(), $entity, array(
            'action' => $this->generateUrl('tour_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tour entity.
     *
     */
    public function newAction()
    {
        $entity = new Tour();
        $form   = $this->createCreateForm($entity);

        return $this->render('MapBundle:Tour:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tour entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tour entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MapBundle:Tour:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tour entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tour entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MapBundle:Tour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Tour entity.
    *
    * @param Tour $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tour $entity)
    {
        $form = $this->createForm(new TourType(), $entity, array(
            'action' => $this->generateUrl('tour_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tour entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MapBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tour entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tour_edit', array('id' => $id)));
        }

        return $this->render('MapBundle:Tour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Tour entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MapBundle:Tour')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tour entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tour'));
    }

    /**
     * Creates a form to delete a Tour entity by id.
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
