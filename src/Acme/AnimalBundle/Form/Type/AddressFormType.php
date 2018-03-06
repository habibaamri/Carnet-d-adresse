<?php

namespace AnimalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;


class AddressFormType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('animal', 'text', array(
                'label' => 'Prénom',
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('age', 'text', array(
                'label' => 'Nom',
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('famille', 'text', array(
                'label' => "Téléphone",
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('race', 'email', array(
                'attr' => array(
                    'class' => 'form-control',
                )))
              ->add('nourriture', 'text', array(
                    'label' => "Téléphone",
                    'attr' => array(
                        'class' => 'form-control',
                    )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnimalBundle\Entity\Email',
            'intention'  => 'address_form',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'address_form_type';
    }
}
