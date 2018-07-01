<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegionsController extends Controller
{
    /**
     * @Route("/", name="regions")
     */
    public function index()
    {
        return $this->render('regions/index.html.twig', [
            'controller_name' => 'RegionsController',
        ]);
    }
}
