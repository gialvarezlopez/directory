<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ciCompany')
            ->add('ciPhone1')
            ->add('ciPhone2')
            ->add('ciAddress')
            //->add('ciLat')
            //->add('ciLng')
            ->add('ciActive')
            //->add('cat')
            //->add('ciSchedule')
            //->add('ciCreated', 'datetime')
            //->add('cit')
            //->add('usr')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ContactInfo'
        ));
    }
}
