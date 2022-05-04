<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobs=['Administratif ',
            'Aéronautique et transport aérien',
             'Agriculture',
             'Agroalimentaire',
             ' Architecte - BTP - Urbanisme',
             'Armée de Terre',
             'Art',
             'Artisanat'];
        for($i=0;$i<count($jobs);$i++){
            $job=new Job();
            $job->setDesignation($jobs[$i]);
            $manager->persist($job);
        }
        $manager->flush();
    }
}
