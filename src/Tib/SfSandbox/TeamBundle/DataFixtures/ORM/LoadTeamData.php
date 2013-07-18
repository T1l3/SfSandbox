<?php

namespace Tib\SfSandbox\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tib\SfSandbox\TeamBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $datas = array(
            array('Team 1', 'team1', 'description', true),
            array('Team 2', 'team2', 'description', true),
            array('Team 3', 'team3', 'description', false),
        );

        foreach ($datas as $data) {
            $team = new Team();
            $team->setName($data[0]);
            $team->setSlug($data[1]);
            $team->setDescription($data[2]);
            $team->setIsActive($data[3]);

            $manager->persist($team);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}