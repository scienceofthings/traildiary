<?php

namespace App\Controller;

use App\Entity\Trail;
use App\Form\TrailType;
use App\Repository\TrailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trail")
 */
class TrailController extends Controller
{
    /**
     * @Route("/", name="trail_index", methods="GET")
     */
    public function index(TrailRepository $trailRepository): Response
    {
        return $this->render('trail/index.html.twig', ['trails' => $trailRepository->findAll()]);
    }

    /**
     * @Route("/new", name="trail_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $trail = new Trail();
        $form = $this->createForm(TrailType::class, $trail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();

            return $this->redirectToRoute('trail_index');
        }

        return $this->render('trail/new.html.twig', [
            'trail' => $trail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trail_show", methods="GET")
     */
    public function show(Trail $trail): Response
    {
        return $this->render('trail/show.html.twig', ['trail' => $trail]);
    }

    /**
     * @Route("/{id}/edit", name="trail_edit", methods="GET|POST")
     */
    public function edit(Request $request, Trail $trail): Response
    {
        $form = $this->createForm(TrailType::class, $trail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trail_edit', ['id' => $trail->getId()]);
        }

        return $this->render('trail/edit.html.twig', [
            'trail' => $trail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trail_delete", methods="DELETE")
     */
    public function delete(Request $request, Trail $trail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trail);
            $em->flush();
        }

        return $this->redirectToRoute('trail_index');
    }
}
