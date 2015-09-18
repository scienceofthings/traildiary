<?php

namespace Ghyneck\MapBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TourImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('altText')
            ->add('image', 'vich_file');
            //->add('image');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ghyneck\MapBundle\Entity\TourImage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ghyneck_mapbundle_tour_image';
    }
}
