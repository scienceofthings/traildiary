<?php

namespace App\Form;

use App\Entity\Trail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('directory')
            ->add('gpxFileName')
            ->add('gpxFile')
            ->add('markerLatitude')
            ->add('markerLongitude')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trail::class,
        ]);
    }
}
