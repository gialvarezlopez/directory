<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\PropertyAccess\PropertyPath;

class MedicalDetailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('mdProfileImage', FileType::class, array( "label"=>"Foto","required"=>"", "attr"=>array( "class"=>"form-name form-control" ), "data_class" => null ))
            ->add('mdProfileDescription')
            ->add('mdAcademicTraining')
            ->add('mdProfessionalExperience')
            ->add('mdCoursesSeminars')
            ->add('mdAditionalInformation')
            ->add('mdFirstName')
            ->add('mdMiddleName')
            ->add('mdFirstSurname')
            ->add('mdSecondSurname')
            ->add('mdActive')
            
            //->add('mdCreated', 'datetime')
            //->add('mdUpdated', 'datetime')
            //->add('usr')
            /*
            ->add("Save", SubmitType::class, array(
                "attr" => array(
                    "class"=>"form-submit btn btn-success margin-top ",
                )
            ) 
        )
        */
        ->add('extraSpeciality', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
				
            "class" => "AppBundle:Speciality",
            'mapped'=>false,
            'required'=> false,
            //'placeholder' => 'Seleccione el pais',
            //'empty_data'  => null,
            'multiple'=> true,
            "attr"=>array( "class"=>"" ),
            //'data' => array(),
            'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder('q')->where('q.spActive = 1')->orderBy('q.spName', 'ASC');
            },

        ))
        ;
       
        //$builder->add('extraSpeciality', TextareaType::class,  array(
        //    'label' => 'Specialities :',
        //    "required"=>false,
        //    'mapped' => false,

        //));

        /*    
        $builder->add('states', ChoiceType::class, array(
                'placeholder' => 'Choose an option',
                'mapped' => false,
                'required' => false,
                "multiple"=>true,
                'choices' => array(
                    'English' => 'en',
                    'Spanish' => 'es',
                    'Bork'   => 'muppets',
                    'Pirate' => 'arr',
                ),
        ));  
        */  
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MedicalDetail'
        ));
    }
}
