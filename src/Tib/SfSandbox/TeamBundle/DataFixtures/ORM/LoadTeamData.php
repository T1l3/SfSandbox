<?php

namespace Tib\SfSandbox\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tib\SfSandbox\TeamBundle\Entity\Team;
use Tib\SfSandbox\TeamBundle\Entity\Player;

class LoadTeamData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $datas = array(
            array('Team 1', 'team1', 'description', true),
            array('Team 2', 'team2', 'description', true),
            array('Team 3', 'team3', 'description', false),
        );

        foreach ($datas as $data) {
            $team = new Team();
            $team->setName($data[0]);
            $team->setSlug($data[1]);
            $team->setDescription($faker->text());
            $team->setIsActive($data[3]);

            for ($i=0; $i < 10; $i++) {
                $player = new Player();
                $player->setFirstname($faker->firstName());
                $player->setLastname($faker->lastName());
                $player->setBirthday(new \Datetime($faker->date()));
                $player->setTeam($team);
                $manager->persist($player);
            }

            $manager->persist($team);
        }
        $manager->flush();
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}