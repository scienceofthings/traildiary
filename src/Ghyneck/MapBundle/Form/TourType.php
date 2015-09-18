<?php

namespace Ghyneck\MapBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ghyneck\MapBundle\Entity\TourImage;

class TourType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('gpx_file', 'vich_file',
                array(
                    'required'      => false,
                    'allow_delete'  => true, // not mandatory, default is true
                    'download_link' => true // not mandatory, default is true
                )
            );
            $builder->add('tourImages', 'collection', array(
                'type' => new TourImageType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ghyneck\MapBundle\Entity\Tour'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ghyneck_mapbundle_tour';
    }
}
