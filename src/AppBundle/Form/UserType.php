<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('usrUsername')
            ->add('usrPassword', PasswordType::class)
            ->add('usrEmail', EmailType::class)
            //->add('usrRole')
            //->add('usrEstatus')
            //->add('usrCreated', 'datetime')
            //->add('usrUpdated', 'datetime')
            //->add('usrActive')
            ->add('cou')
            //->add('st')
        ;
        $builder->add('repeatPassword', PasswordType::class,  array(
            'label' => 'Repeat Password :',
            "required"=>true,
            'mapped' => false,
            //"attr"=>array( "class"=>"form-tag form-control" )
        ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
