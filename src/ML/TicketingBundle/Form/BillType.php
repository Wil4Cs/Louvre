<?php

namespace ML\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            ))
            ->add('email', RepeatedType::class, array(
                'type'              => EmailType::class,
                'invalid_message'   => 'Les adresses mail doivent êtres identiques.',
                'first_options'     => array('label' => 'Indiquez votre Email'),
                'second_options'    => array('label' => 'Confirmez votre Email'),
            ))
            ->add('daily', ChoiceType::class, array(
                'choices' => array(
                    'Journée' => true,
                    'Demi-journée' => false
                ),
                'expanded'=> true,
                'multiple'=> false
            ))
            ->add('ticket_number',ChoiceType::class, array(
                'disabled' => true,
                'placeholder' => 'Choisissez le nombre de billets',
                'choices'     => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10'=> 10
                ),
            ))
            ->add('tickets', CollectionType::class, array(
                'label'        => false,
                'entry_type'   => TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))
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
