<?php

namespace App\Form;

use App\Entity\ExerciceRespiration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;

class ExerciceRespirationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un nom pour l\'exercice']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('dureeInspiration', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer la durée d\'inspiration']),
                    new Positive(['message' => 'La durée doit être un nombre positif']),
                ],
            ])
            ->add('dureeApnee', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer la durée d\'apnée']),
                    new Positive(['message' => 'La durée doit être un nombre positif']),
                ],
            ])
            ->add('dureeExpiration', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer la durée d\'expiration']),
                    new Positive(['message' => 'La durée doit être un nombre positif']),
                ],
            ])
            ->add('publier', CheckboxType::class, [
                'required' => false,
                'label' => 'Publié',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciceRespiration::class,
        ]);
    }
}
