<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CharacterType extends AbstractType
{
    public const CLASSES = ['Druid' => 'Druid', 'Evoker' => 'Evoker', 'Demon Hunter' => 'Demon Hunter', 'Warrior' => 'Warrior', 'Mage' => 'Mage', 'Hunter' => 'Hunter', 'Rogue' => 'Rogue', 'Death Knight' => 'Death Knight', 'Monk' => 'Monk', 'Paladin' => 'Paladin', 'Priest' => 'Priest', 'Warlock' => 'Warlock', 'Shaman' => 'Shaman'];
    public const RACES = ['Human' => 'Human', 'Dwarf' => 'Dwarf', 'Night Elf' => 'Night Elf', 'Gnome' => 'Gnome', 'Draenei' => 'Draenei', 'Worgen' => 'Worgen', 'Pandaren' => 'Pandaren', 'Dracthyr' => 'Dracthyr', 'Orc' => 'Orc', 'Undead' => 'Undead', 'Tauren' => 'Tauren', 'Troll' => 'Troll', 'Blood Elf' => 'Blood Elf', 'Goblin' => 'Goblin'];
    public const ROLES = ['Tank' => 'Tank', 'Healer' => 'Healer', 'Damage Dealer' => 'Damage Dealer'];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center'
                ],
            ])
            ->add('class', ChoiceType::class, [
                'placeholder' => '- Class -',
                'choices' => self::CLASSES,
                'attr' => [
                    'class' => 'form-control text-center'
                ],
                'constraints' => [
                    new NotBlank(null, 'You must choose a class')
                ],
            ])
            ->add('race', ChoiceType::class, [
                'placeholder' => '- Race -',
                'choices' => self::RACES,
                'attr' => [
                    'class' => 'form-control text-center'
                ],
                'constraints' => [
                    new NotBlank(null, 'You must choose a class')
                ],
            ])
            ->add('role', ChoiceType::class, [
                'placeholder' => '- Role -',
                'choices' => self::ROLES,
                'attr' => [
                    'class' => 'form-control text-center'
                ],
                'constraints' => [
                    new NotBlank(null, 'You must choose a class')
                ],
            ])
            ->add('score', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center'
                ],
            ])
            ->add('gearScore',TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
