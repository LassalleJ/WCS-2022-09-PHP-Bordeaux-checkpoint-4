<?php

namespace App\DataFixtures;

use App\Entity\Specificity;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const USERNAMES=['Reianto', 'Linolf', 'Disiel', 'Ludval', 'Dragokesh', 'Iusuth', 'Rasbald' ,'Rianter' ,'Nanin' ,'Ludbet', 'Balduron', 'Nintir', 'Ednidas', 'Fastkev', 'Trysthor', 'Rianbald', 'Eeraob', 'Flonas', 'Wulfvell', 'Claivell', 'Garhadri', 'Hectian', 'Norefre', 'Ningar'];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $user = new User;
            $user->setEmail($faker->email());
            $user->setUsername($faker->randomElement(self::USERNAMES));
            $user->setPassword(password_hash('123456789', null));
            $user->setBattletag($faker->userName());
            if ($i % 2) {
                $user->setDiscord($faker->userName());
            }
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }
        $index = 0;
        for ($j = 16; $j < 25; $j++) {
            for ($k = 0; $k < 5; $k++) {
                $user = new User();
                if($k===0) {
                    $user->setIsLeader(true);
                }
                $user->setEmail($faker->email());
                $user->setUsername($faker->randomElement(self::USERNAMES));
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $j));
                $this->addReference('spec_user_' . $index, $user);
                $index++;
                $manager->persist($user);
            }
        }
        $casuIndex = 0;
        for ($l = 0; $l < 4; $l++) {
            for ($m = 0; $m < 4; $m++) {
                $user = new User();
                if($m===0) {
                    $user->setIsLeader(true);
                }
                $user->setEmail($faker->email());
                $user->setUsername($faker->randomElement(self::USERNAMES));
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('casu_user_' . $casuIndex, $user);
                $casuIndex++;
                $manager->persist($user);
            }

        }
        $bothIndex=0;
        for ($l = 4; $l < 8; $l++) {
            for ($m = 0; $m < 3; $m++) {
                if ($m === 0) {
                    $user->setIsLeader(true);
                }
                $user = new User();
                $user->setEmail($faker->email());
                $user->setUsername($faker->randomElement(self::USERNAMES));
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('both_user_' . $bothIndex, $user);
                $bothIndex++;
                $manager->persist($user);
            }
        }
        $tryhardIndex=0;
        for ($l = 8; $l < 12; $l++) {
            for ($m = 0; $m < 2; $m++) {
                $user = new User();
                if ($m === 0) {
                    $user->setIsLeader(true);
                }
                $user->setEmail($faker->email());
                $user->setUsername($faker->randomElement(self::USERNAMES));
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('tryhard_user_' .$tryhardIndex, $user);
                $tryhardIndex++;
                $manager->persist($user);
            }
        }
        $casualFlexIndex=0;
        for ($l = 12; $l < 16; $l++) {
            for ($m = 0; $m < 1; $m++) {
                $user = new User();
                $user->setIsLeader(true);
                $user->setEmail($faker->email());
                $user->setUsername($faker->randomElement(self::USERNAMES));
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('casualflex_user_' . $casualFlexIndex, $user);
                $casualFlexIndex++;
                $manager->persist($user);
            }
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GroupFixtures::class,
        ];
    }
}
