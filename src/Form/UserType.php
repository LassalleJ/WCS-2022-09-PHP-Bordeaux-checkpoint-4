<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
//                'label' => 'Title',
                'label_attr' => [
                    'class' => 'inputLabel'
                ],
                'attr' => [
                    'class' => 'emailInput form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255, maxMessage: ('The title cannot be longer than 255 characters'))
                ],
                'required' => false,
            ])
            ->add('username', TextType::class, [
//                'label' => 'Title',
                'label_attr' => [
                    'class' => 'inputLabel'
                ],
                'attr' => [
                    'class' => 'emailInput form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255, maxMessage: ('The title cannot be longer than 255 characters'))
                ],
                'required' => false,
            ])
            ->add('battletag', TextType::class, [
//                'label' => 'Title',
                'label_attr' => [
                    'class' => 'inputLabel'
                ],
                'attr' => [
                    'class' => 'emailInput form-control',
                ],
                'constraints' => [
                    new Length(max: 255, maxMessage: ('The title cannot be longer than 255 characters'))
                ],
                'required' => false,
            ])
            ->add('discord', TextType::class ,[
//                'label' => 'Title',
                'label_attr' => [
                    'class' => 'inputLabel'
                ],
                'attr' => [
                    'class' => 'emailInput form-control',
                ],
                'constraints' => [
                    new Length(max: 255, maxMessage: ('The title cannot be longer than 255 characters'))
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
