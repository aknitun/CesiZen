<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class RequestPasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un email']),
                    new Email(['message' => 'Veuillez entrer un email valide']),
                ],
                'label' => 'Email',
            ])
            ->add('reponseQuestionSecrete', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez répondre à la question secrète']),
                ],
                'label' => 'Quelle est ta couleur préférée ?',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // on map sur un tableau, pas sur User directement
            'data_class' => null,
        ]);
    }
}