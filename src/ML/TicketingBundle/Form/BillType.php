<?php

namespace ML\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDay', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'le format de la date doit être dd/mm/yyyy'
            ))
            ->add('email', RepeatedType::class, array(
                'type'              => EmailType::class,
                'invalid_message'   => 'Les adresses mail doivent correspondre.',
                'first_options'     => array('label' => 'Indiquez votre Email'),
                'second_options'    => array(
                    'label' => 'Confirmez votre Email',
                    // Those attributes are required for the JQuery Form Validator only
                    'attr' => array('data-validation' => 'confirmation', 'data-validation-confirm' => 'ml_ticketingbundle_bill[email][first]')),
            ))
            ->add('daily', ChoiceType::class, array(
                'choices' => array(
                    'Journée' => true,
                    'Demi-journée' => false
                ),
                'invalid_message' => 'Cochez sans modifier la valeur!',
                'expanded'=> true,
                'multiple'=> false
            ))
            ->add('tickets', CollectionType::class, array(
                'label'        => false,
                'entry_type'   => TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\TicketingBundle\Entity\Bill'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ml_ticketingbundle_bill';
    }


}
