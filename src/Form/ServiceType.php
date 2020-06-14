<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            
            ->add('label') 
            /*
            ->add('label', ChoiceType::class, [
                'choices'  => [
                    'Piscine' => 'Piscine',
                    'Parking' => 'Parking',
                    
                ]
            ])
*/
            /*
            ->add(
                'hotels',
                CollectionType::class,
                [
                    'entry_type' => HotelType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
        */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
       
    }
}
