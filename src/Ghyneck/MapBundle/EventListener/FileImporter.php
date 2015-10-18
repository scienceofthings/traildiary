<?php
namespace Ghyneck\MapBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use MapBundle\Entity\Tour;

class FileImporter
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Tour) {
            $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
            $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
            $this->setGpxFileName('ghy.gpx');
            $ghy = 1;
            $ghy = 2;
            // ... do something with the Product
        }
    }
}