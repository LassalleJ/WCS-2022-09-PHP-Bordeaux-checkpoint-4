<?php

namespace App\DataFixtures;

use App\Entity\Specificity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SpecificityFixtures extends Fixture implements DependentFixtureInterface
{
    public const PLAYING_WAY=['casual','tryhard','both'];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i=0;$i<50;$i++){
            $spec = new Specificity();
            $spec->setUser($this->getReference('user_' . $i));
            if ($i % 2) {
                $spec->setClassFlexibility(true);
            } else {
                $spec->setClassFlexibility(false);
            }
            if ($i % 5 ) {
                $spec->setRoleFlexibility(true);
            } else {
                $spec->setRoleFlexibility(false);
            }
            $spec ->setPlayingWay($faker->randomElement(self::PLAYING_WAY));
            $spec->setSpeakEnglish($faker->randomElement([true, false]));
            $manager->persist($spec);
        }
        for ($i=0;$i<45;$i++){
            $spec = new Specificity();
            $spec->setSpeakEnglish(true);
            $spec->setPlayingWay('tryhard');
            $spec->setClassFlexibility(true);
            $spec->setRoleFlexibility(false);
            $spec->setUser($this->getReference('spec_user_' . $i));
            $manager->persist($spec);
        }
        for($i=0; $i<4; $i++) {
            $specCasu=new Specificity();
            $specCasu->setSpeakEnglish(true);
            $specCasu->setPlayingWay('casual');
            $specCasu->setRoleFlexibility(false);
            $specCasu->setClassFlexibility(false);
            $specCasu->setUser($this->getReference('casu_user_' . $i));
            $manager->persist($spec);
        }
        for($i=4; $i<8; $i++) {
            $specCasu=new Specificity();
            $specCasu->setSpeakEnglish(true);
            $specCasu->setPlayingWay('both');
            $specCasu->setRoleFlexibility(true);
            $specCasu->setClassFlexibility(true);
            $specCasu->setUser($this->getReference('both_user_' . $i));
            $manager->persist($spec);
        }
        for($i=8; $i<12; $i++) {
            $specCasu=new Specificity();
            $specCasu->setSpeakEnglish(true);
            $specCasu->setPlayingWay('tryhard');
            $specCasu->setRoleFlexibility(true);
            $specCasu->setClassFlexibility(true);
            $specCasu->setUser($this->getReference('tryhard_user_' . $i));
            $manager->persist($spec);
        }
        for($i=12; $i<16; $i++) {
            $specCasu=new Specificity();
            $specCasu->setSpeakEnglish(true);
            $specCasu->setPlayingWay('tryhard');
            $specCasu->setRoleFlexibility(true);
            $specCasu->setClassFlexibility(true);
            $specCasu->setUser($this->getReference('casualflex_user_' . $i));
            $manager->persist($spec);
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
