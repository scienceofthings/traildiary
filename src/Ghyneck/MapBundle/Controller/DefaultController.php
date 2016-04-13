<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Entity\Gpxfile;
use Ghyneck\MapBundle\Helper\GPXIngest;

class DefaultController extends Controller
{
    
            
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MapBundle:Tour')->findAll();
        
        return $this->render('MapBundle:Default:index.html.twig', array(
            'entities' => $entities,
        ));
    }
}
