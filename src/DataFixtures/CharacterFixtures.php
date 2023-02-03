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
    public const PSEUDO = ['Trysvar', 'Neryon', 'Floclai', 'Flova', 'Leoarchi', 'Medpark', 'Tirsandre', 'Edhald', 'Montor', 'Elitir', 'Antoros', 'Baldva', 'Leojac', 'Sandreand', 'Ulljeng', 'Iusjac', 'Parkthor', 'Isrian', 'Rhouron', 'Thosval', 'Jacflo', 'Uliuli', 'Winvin', 'Gariland'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('user_' . $i));
            $char->setClass($faker->randomElement(self::CLASSES));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setRole($faker->randomElement(self::ROLES));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
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
        $index = 16;
        for ($i = 0; $i < 45; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('spec_user_' . $i));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
            $char->setGearScore($faker->numberBetween(408, 420));
            $char->setScore($faker->numberBetween(2600, 3000));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i === 0 || $i === 5 || $i === 10 || $i === 15 || $i === 20 || $i === 25 || $i === 30 || $i === 35 || $i === 40) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i === 1 || $i === 6 || $i === 11 || $i === 16 || $i === 21 || $i === 26 || $i === 31 || $i === 36 || $i === 41) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            } else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            if ($i === 4 || $i === 9 || $i === 14 || $i === 19 || $i === 24 || $i === 29 || $i === 34 || $i === 39) {
                $index++;
            }
            $manager->persist($char);
        }
        $index = 0;
        for ($i = 0; $i < 16; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('casu_user_' . $i));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
            $char->setGearScore($faker->numberBetween(370, 390));
            $char->setScore($faker->numberBetween(500, 1200));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i === 0 || $i === 8 || $i === 12) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i === 4 || $i === 9 || $i === 13) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            } else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            if ($i === 3 || $i === 7 || $i === 11) {
                $index++;
            }
            $manager->persist($char);
        }
        $index = 4;
        for ($i = 0; $i < 12; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('both_user_' . $i));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
            $char->setGearScore($faker->numberBetween(390, 405));
            $char->setScore($faker->numberBetween(1700, 2200));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i === 0 || $i === 6 || $i === 9) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i === 3 || $i === 7 || $i === 10) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            } else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            if ($i === 2 || $i === 5 || $i === 8) {
                $index++;
            }
            $manager->persist($char);
        }

        $index = 8;
        for ($i = 0; $i < 8; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('tryhard_user_' . $i));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
            $char->setGearScore($faker->numberBetween(408, 420));
            $char->setScore($faker->numberBetween(2400, 3000));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i === 0 || $i === 6) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i === 1 || $i === 2) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            } else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            if ($i === 1 || $i === 3 || $i === 5) {
                $index++;
            }
            $manager->persist($char);
        }

        $index = 12;
        for ($i = 0; $i < 4; $i++) {
            $char = new Character();
            $char->setUser($this->getReference('casualflex_user_' . $i));
            $char->setPseudo($faker->randomElement(self::PSEUDO));
            $char->setGearScore($faker->numberBetween(375, 390));
            $char->setScore($faker->numberBetween(800, 1500));
            $char->setRace($faker->randomElement(self::RACES));
            $char->setInGroup($this->getReference('group_' . $index));
            if ($i === 0 || $i === 2) {
                $char->setClass($faker->randomElement(['Paladin', 'Demon Hunter', 'Death Knight', 'Warrior', 'Monk', 'Druid']));
                $char->setRole('Tank');
            } elseif ($i === 1) {
                $char->setClass($faker->randomElement(['Paladin', 'Shaman', 'Priest', 'Evoker', 'Monk', 'Druid']));
                $char->setRole('Healer');
            } else {
                $char->setClass($faker->randomElement(self::CLASSES));
                $char->setRole('Damage Dealer');
            }
            $index++;
            $manager->persist($char);
        }
        $manager->flush();
    }

    public
    function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
