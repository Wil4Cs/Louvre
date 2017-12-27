<?php

namespace ML\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('visitDay', DateTimeType::class, ['label'=>'Sélectionnez le jour de visite'])
            ->add('email', RepeatedType::class, array(
                'type'              => EmailType::class,
                'invalid_message'   => 'Les adresses mail doivent êtres identiques.',
                'required'          => true,
                'first_options'     => array('label' => 'Indiquez votre Email'),
                'second_options'    => array('label' => 'Confirmez votre Email'),
            ))
            ->add('ticket_number',ChoiceType::class, array(
                'placeholder' => 'Choisissez le nombre de tickets',
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
