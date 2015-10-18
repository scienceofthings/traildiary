<?php
namespace Ghyneck\MapBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ghyneck\MapBundle\Entity\Tour;

class FileImporter
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $tour = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($tour instanceof Tour) {
            $vichUploaderMappings = $this->container->getParameter('vich_uploader.mappings');
            $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
            $tour->setGpxFileName('ghy.gpx');
            $ghy = 1;
            $ghy = 2;
            // ... do something with the Product
        }
    }
}