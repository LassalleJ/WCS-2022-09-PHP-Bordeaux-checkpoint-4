<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for($i=0;$i<25;$i++) {
            $group = new Group();
            $group->setName($faker->userName());
            if($i > 15) {
                $group->setIsFull(true);
            }else {
                $group->setIsFull(false);
            }
            $this->addReference('group_' . $i, $group);
            $manager->persist($group);
        }
        $manager->flush();
    }
}
