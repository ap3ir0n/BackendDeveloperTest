<?php

namespace AppBundle\Form;

use AppBundle\Entity\Grade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', NumberType::class, [
                'scale' => 2,
                'required' => true,
                'label' => 'Grade',
                'attr' => [
                    'class' => 'text-right'
                ]
            ])->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Grade::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_grade';
    }


}
