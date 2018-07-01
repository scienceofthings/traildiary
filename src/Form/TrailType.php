<?php

namespace App\Form;

use App\Entity\Trail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TrailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('directory')
            ->add('region', 'entity', array(
                'class' => 'Region',
                'property' => 'title'))
            ->add('region', EntityType::class, array(
                'class' => \App\Entity\Region::class,
                'choice_label' => 'title',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trail::class,
        ]);
    }
}
