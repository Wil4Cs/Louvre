<?php

namespace ML\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'Prénom',
                // Those attributes are required for the JQuery Form Validator only
                'attr'  => array(
                    'data-validation'        => 'length',
                    'data-validation-length' => '3-30'
                )
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom',
                // Those attributes are required for the JQuery Form Validator only
                'attr'  => array(
                    'data-validation'        => 'length',
                    'data-validation-length' => '3-30'
                )
            ))
            ->add('birthday', BirthdayType::class, array(
                'widget' => 'single_text',
                'html5'  => false,
                'format' => 'dd/MM/yyyy',
                'label'  => 'Date de Naissance',
                'attr'   => array(
                    'class'                  => 'birthDatePicker',
                    // Those attributes are required for the JQuery Form Validator only
                    'data-validation'        => 'birthdate',
                    'data-validation-format' => 'dd/mm/yyyy')

            ))
            ->add('reduction', ChoiceType::class, array(
                'choices' => array(
                    'Oui (pour les + de 12ans seulement)' => true,
                    'Non' => false
                ),
                'expanded'=> true,
                'multiple'=> false
            ))
            ->add('country', CountryType::class, array(
                'data'  => 'FR',
                'label' => 'Pays'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\TicketingBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ml_ticketingbundle_ticket';
    }


}
