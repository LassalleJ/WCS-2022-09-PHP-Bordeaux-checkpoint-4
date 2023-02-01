<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public const CLASSES = ['Druid', 'Evoker', 'Demon Hunter', 'Warrior', 'Mage', 'Hunter', 'Rogue', 'Death Knight', 'Monk', 'Paladin', 'Priest', 'Warlock', 'Shaman'];
    public const RACES = ['Human', 'Dwarf', 'Night Elf', 'Gnome', 'Draenei', 'Worgen', 'Pandaren', 'Dracthyr', 'Orc', 'Undead', 'Tauren', 'Troll', 'Blood Elf', 'Goblin'];
    public const ROLES = ['Tank', 'Healer', 'Damage Dealer'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('user_' . $i));
            $char->setClass($faker->randomElement(self::CLASSES));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setRole($faker->randomElement(self::ROLES));
            $char->setPseudo($faker->name());
            $ilvl = $faker->numberBetween(360, 420);
            $char->setGearScore($ilvl);
            if ($ilvl < 390) {
                $char->setScore($faker->numberBetween(0, 1500));
            } elseif ($ilvl < 400) {
                $char->setScore($faker->numberBetween(1500, 2300));
            } elseif ($ilvl < 420) {
                $char->setScore($faker->numberBetween(2300, 3000));
            }
            $manager->persist($char);
        }
        $index=16;
        for ($i = 0; $i < 45; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('spec_user_' . $i));
            $char->setPseudo($faker->name());
            $char->setGearScore($faker->numberBetween(408, 420));
            $char->setScore($faker->numberBetween(2600, 3000));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i ===0 || $i === 5|| $i === 10|| $i === 15|| $i === 20|| $i === 25|| $i === 30|| $i === 35|| $i === 40) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i===1 || $i ===6 || $i ===11 || $i === 16 || $i === 21 || $i === 26|| $i === 31|| $i === 36|| $i === 41) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            }else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            if ($i ===4 || $i === 9|| $i === 14|| $i === 19|| $i === 24|| $i === 29|| $i === 34|| $i === 39|| $i === 44) {
                $index++;
            }
            $manager->persist($char);
        }
            $manager->flush();
        }

    public function getDependencies():array
    {
        return [
            UserFixtures::class,
        ];
    }
    }
