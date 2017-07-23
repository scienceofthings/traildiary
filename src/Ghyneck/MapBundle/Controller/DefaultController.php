<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
            
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MapBundle:Tour')->findAll();
        
        return $this->render('MapBundle:Default:index.html.twig', array(
            'entities' => $entities,
            'ghyneck_map_url' => $this->container->getParameter('ghyneck_map.map.url')
        ));
    }
}
