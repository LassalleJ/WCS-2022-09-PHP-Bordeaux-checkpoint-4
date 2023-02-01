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
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for ($i = 0 ; $i<100 ; $i++) {
            $user = new User;
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName());
            $user->setPassword(password_hash('123456789', null));
            $user->setBattletag($faker->userName());
            if ($i % 2) {
                $user->setDiscord($faker->userName());
            }
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }
        $index=0;
        for ($j = 16 ; $j < 25 ; $j++) {
            for( $k = 0 ; $k < 5 ; $k++) {
                $user = new User();
                $user->setEmail($faker->email());
                $user->setUsername($faker->userName());
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
        for ($l=0;$l<16;$l++) {
            if ($l<4) {
                $user = new User();
                $user->setEmail($faker->email());
                $user->setUsername($faker->userName());
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('casu_user_'.$l, $user);
                $manager->persist($user);
            }
            if ($l<8) {
                $user = new User();
                $user->setEmail($faker->email());
                $user->setUsername($faker->userName());
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('both_user_'.$l, $user);
                $manager->persist($user);
            }
            if ($l<12) {
                $user = new User();
                $user->setEmail($faker->email());
                $user->setUsername($faker->userName());
                $user->setPassword(password_hash('123456789', null));
                $user->setBattletag($faker->userName());
                $user->setBattletag($faker->userName());
                $user->setDiscord($faker->userName());
                $user->setInParty($this->getReference('group_' . $l));
                $this->addReference('tryhard_user_'.$l, $user);
                $manager->persist($user);

            }
            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName());
            $user->setPassword(password_hash('123456789', null));
            $user->setBattletag($faker->userName());
            $user->setBattletag($faker->userName());
            $user->setDiscord($faker->userName());
            $user->setInParty($this->getReference('group_' . $l));
            $this->addReference('casualflex_user_'.$l, $user);
            $manager->persist($user);



        }


        $manager->flush();
    }

    public function getDependencies():array
    {
        return [
            GroupFixtures::class,
        ];
    }
}
