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
        $trackPointsInLeafletFormat = $this->getTracks();        
        return $this->render('MapBundle:Default:index.html.twig', array(
            'trackPointsInLeafletFormat' => $trackPointsInLeafletFormat,            
        ));       
    }        

    protected function getTracks()
    {                        
        $tours = $this->getDoctrine()
                ->getRepository('MapBundle:Tour')
                ->findAll();
        if (!$tours) {
            throw $this->createNotFoundException(
                    'No tours found'
            );
        }

        $gpxFile = $tours[0]->getGpxFile();
        $fileName = $gpxFile->getFileName();
        
        
        $gpx = new GPXIngest();
        $gpx->loadFile('/var/www/symfony/playground/web/uploads/documents/' . $fileName);
        $gpx->ingest(); 
        $trackPoints = $gpx->getSegment('journey0','seg0')->points;        
        $trackPointsInLeafletFormat = "[";
        foreach($trackPoints as $trackPoint){
            $trackPointsInLeafletFormat .= sprintf("new L.LatLng(%s,%s),", $trackPoint->lat, $trackPoint->lon);
        }        
        $trackPointsInLeafletFormat .= "]";
        return $trackPointsInLeafletFormat;
           
    }
}
