<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Entity\Service;
use App\Entity\CategoryHotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Hotel1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name')
        ->add('address')
        ->add('description')
        ->add('status', ChoiceType::class, [
            'choices' => [
                'actif' => 'actif',
                'supprimé' => 'supprimé',
                'en travaux' => 'en travaux',
            ]
        ])
        ->add('imageName')
        ->add('imageFile' , VichImageType::class)
        ->add('categoryHotel', EntityType::class, [
            'class' => CategoryHotel::class,
            "choice_label" => 'label'
        ])
        ->add('services', EntityType::class, [
            'class' => Service::class,
            'choice_label' => 'label'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
