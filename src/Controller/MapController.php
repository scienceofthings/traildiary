<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{

    /**
     * @Route("/", name="map")
     */
    public function index()
    {
        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }
}
