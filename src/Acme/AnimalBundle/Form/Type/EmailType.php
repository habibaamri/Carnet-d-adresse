<?php

namespace AnimalBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnimalFormType
 * @package AnimalBundle\Form\Type
 */
class AnimalType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Nom et prénom',
                    'class' => 'form-control',
                ),
            ))
            ->add('Animal', 'Animal', array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Animal',
                    'class' => 'form-control',
                ),
            ))
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnimalBundle\Entity\Animal',
            'intention' => 'Animal_form',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getAnimal()
    {
        return 'Animal_form_type';
    }
}
