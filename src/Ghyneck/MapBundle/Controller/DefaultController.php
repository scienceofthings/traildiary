<?php

namespace Ghyneck\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ghyneck\MapBundle\Entity\Product;
use Ghyneck\MapBundle\Entity\Category;
use Ghyneck\MapBundle\Helper\GPXIngest;

class DefaultController extends Controller
{
    
            
    public function indexAction()
    {       
        //$product = $this->saveCategoryAndProduct();
        $products = $this->getCategoriesProducts();        
   
        $trackPointsInLeafletFormat = $this->getTracks();        
        return $this->render('MapBundle:Default:index.html.twig', array(
            'trackPointsInLeafletFormat' => $trackPointsInLeafletFormat,
            'products' => $products,            
        ));       
    }
    
    protected function getCategoriesProducts() {
        $id = 1;
        $category = $this->getDoctrine()
        ->getRepository('MapBundle:Category')
        ->find($id);
        $products = $category->getProducts();
        return $products;
    }
    
    protected function saveCategoryAndProduct() 
    {
        $category = new Category();
        $category->setName('Main Products');

        $product = new Product();
        $product->setName('Foo');
        $product->setPrice(19.99);
        $product->setDescription('Lorem ipsum dolor');
        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();
        
    }
    
    protected function saveProduct() 
    {
        $product = new Product();
    $product->setName('A Foo Bar');
    $product->setPrice('19.99');
    $product->setDescription('Lorem ipsum dolor');

    $em = $this->getDoctrine()->getManager();

    $em->persist($product);
    $em->flush();
    }
    
    protected function fetchProduct() {
        $id = 1;
        $product = $this->getDoctrine()
                ->getRepository('MapBundle:Product')
                ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }
        return $product;
    }

    protected function getTracks()
    {        
        $gpx = new GPXIngest();
        $gpx->loadFile('/var/www/symfony/playground/src/Ghyneck/MapBundle/Helper/WaldseeKybfelsen.gpx');
        $gpx->ingest(); 
        $trackPoints = $gpx->getSegment('journey0','seg0')->points;        
        $trackPointsInLeafletFormat = "[";
        foreach($trackPoints as $trackPoint){
            $trackPointsInLeafletFormat .= sprintf("new L.LatLng(%s,%s),", $trackPoint->lat, $trackPoint->lon);
        }        
        $trackPointsInLeafletFormat .= "]";
        return $trackPointsInLeafletFormat;
        
        /*        
        $trackPoints = array(
            array(47.956783, 7.893430),
            var point2 = new L.LatLng(47.956768, 7.893452);
      var point3 = new L.LatLng(47.956745, 7.893468);
      var point4 = new L.LatLng(47.956730, 7.893473);
      var point5 = new L.LatLng(47.956715, 7.893478);
      var point6 = new L.LatLng(47.956696, 7.893486);
      var point7 = new L.LatLng(47.956684, 7.893508);
      var point8 = new L.LatLng(47.956669, 7.893525);
      var point9 = new L.LatLng(47.956657, 7.893535);
      var point10 = new L.LatLng(47.956638, 7.893548);
      var point11 = new L.LatLng(47.956623, 7.893555);
      var point12 = new L.LatLng(47.956608, 7.893557);
      var point13 = new L.LatLng(47.956596, 7.893543);
      var point14 = new L.LatLng(47.956585, 7.893518);
      var point15 = new L.LatLng(47.956604, 7.893442);
      var point16 = new L.LatLng(47.956612, 7.893415);
      var point17 = new L.LatLng(47.956619, 7.893387);
      var point18 = new L.LatLng(47.956627, 7.893328);
      var point19 = new L.LatLng(47.956642, 7.893291);
      var point20 = new L.LatLng(47.956657, 7.893252);
      var point21 = new L.LatLng(47.956676, 7.893209);
      var point22 = new L.LatLng(47.956692, 7.893165);
      var point23 = new L.LatLng(47.956703, 7.893126);
      var point24 = new L.LatLng(47.956718, 7.893085);
      var point25 = new L.LatLng(47.956730, 7.893050);
      var point26 = new L.LatLng(47.956738, 7.893010);
      var point27 = new L.LatLng(47.956753, 7.892978);
      var point28 = new L.LatLng(47.956757, 7.892943);
      var point29 = new L.LatLng(47.956764, 7.892895);       
      var point30 = new L.LatLng(47.956779, 7.892852);
        );  
         * 
         */      
    }
}
