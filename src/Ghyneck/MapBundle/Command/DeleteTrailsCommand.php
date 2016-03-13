<?php

namespace Ghyneck\MapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ghyneck\MapBundle\Entity\TourRepository;
use Ghyneck\MapBundle\Entity\Tour;


class DeleteTrailsCommand extends ContainerAwareCommand
{

    /*
     * @var string
     */
    private $uploadDestination;

    protected function configure()
    {
        $this
            ->setName('map:delete:trails')
            ->setDescription('Delete all trails.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setUploadDestination();
        $this->deleteAllTours();
        $output->writeln("All tours and images deleted.");
        return;
    }

    /*
     * @return string
     */
    protected function setUploadDestination()
    {
        $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
        $this->uploadDestination = $vichUploaderMappings['image']['upload_destination'];
    }

    protected function deleteAllTours()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tourRepository = $em->getRepository('MapBundle:Tour');
        $tours = $tourRepository->findAll();
        foreach($tours as $tour){
            $em->remove($tour);
        }
        $em->flush();
    }



}