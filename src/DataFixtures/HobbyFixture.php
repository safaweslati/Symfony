<?php

namespace App\DataFixtures;

use App\Entity\Hobbie;
use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $hobbies=['bowling', 'ice hockey', 'surfing',
                'tennis', 'baseball', 'gymnastics',
                'rock climbing', 'dancing', 'gardening',
                 'karate', 'horse racing', 'snowboarding',
                'skateboarding', 'cycling', 'cheerleading',
                'archery', 'fishing', 'taekwondo',
              'fencing', 'skiing', 'jet skiing',
              'weight lifting', 'scuba diving', 'wind surfing',
              'kickboxing', 'sky diving', 'boxing',
              'board games'];
        for($i=0;$i<count($hobbies);$i++){
            $hobby=new Hobbie();
            $hobby->setDesigniation($hobbies[$i]);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
