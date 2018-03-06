<?php

namespace AnimalBundle\Form\Type;

use AnimalBundle\Controller\Controller;
use AnimalBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Monolog\Formatter\FormatterInterface;
use Symfony\Component\Form\FormError;

class ProfilFormType extends AbstractType
{

    /**"
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('animal', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Animal',
                ),
            ))
            ->add('famille', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Famille',
                ),
            ))
            ->add('age', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Age',
                ),
            ))
            ->add('race', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Race',
                ),
            ))
            ->add('nourriture', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Nourriture',
                ),
            ))

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnimalBundle\Entity\User',
            'intention' => 'profil_form',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'profil_form_type';
    }
}
