<?php

namespace App\Form;

use App\Entity\Specificity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSpecificitiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('playingWay', ChoiceType::class, [
                'attr' => ['class' => 'radio-button-input'],
                'choices'  => [
                    'Casual' => 'casual',
                    'Try hard' => 'tryhard',
                    'Both' => 'both',
                    ],
                'expanded'=>true,
            ])
            ->add('roleFlexibility', ChoiceType::class, [
                'label'=>'Can you play different roles ?',
                'choices'  => [
                    'I do' => true,
                    "I don't" => false,
                ],
                'attr' => ['class' => 'radio-button-input'],
                'expanded'=>true,
            ])
            ->add('classFlexibility', ChoiceType::class, [
                'attr' => ['class' => 'radio-button-input'],
                'label'=>'Can you play different classes ?',
                'choices'  => [
                    'I do' => true,
                    "I don't" => false,
                ],
                'expanded'=>true,
            ])
            ->add('speakEnglish', ChoiceType::class, [
                'attr' => ['class' => 'radio-button-input'],
                'label'=>'Do you speak english ?',
                'choices'  => [
                    'I do' => true,
                    "I don't" => false,
                ],
                'choice_attr' => ['type' => 'button'],
                'expanded'=>true,
            ])
        ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specificity::class,
        ]);
    }
}
