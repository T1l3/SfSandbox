<?php

namespace Tib\SfSandbox\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tib\SfSandbox\UserBundle\Entity\User;

class LoadUserData  extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $datas = array(
            array('profile'=>array('admin', 'admin', 'admin@example.com', 1, 1), 'firstname' => 'John', 'lastname' => 'Doe'),
        );

        for ($i = 0; $i < 100; $i++) {
           $datas[] = array('profile'=>array('user'.$i, 'user'.$i, 'user'.$i.'@example.com', 1, 0), 'firstname' => $faker->firstName(), 'lastname' => $faker->lastName());
        }

        $userManipulator = $this->container->get('sfsandbox_user.util.user_manipulator');

        foreach ($datas as $data) {
            $profile = $data['profile'];
            $user = $userManipulator->create($profile[0], $profile[1], $profile[2], $profile[3], $profile[4], $data['firstname'], $data['lastname']);
            $manager->persist($user);
            $this->addReference($profile[0], $user);
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