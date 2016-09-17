<?php
namespace Ghyneck\MapBundle\Tests\Service;

use Ghyneck\MapBundle\Service\FileImporter;
use Ghyneck\MapBundle\Entity\Tour;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/*
 * Integration Test: writes all available files into the tour
 */
class FileImporterTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $serviceContainer = $this->getMockBuilder(Container::class)
            ->getMock();

        $serviceContainer->method('getParameter')
            ->with($this->parameter)
            ->willReturn('/');

        $tour = $this->getMockBuilder(Tour::class)
            ->getMock();

        $fileImporter = new FileImporter($serviceContainer);
        $fileImporter->assignFilesToTour($tour);
    }
}
