<?php

namespace Tib\SfSandbox\UserBundle\Util;

use FOS\UserBundle\Model\UserManagerInterface;

class UserManipulator
{
    /**
     * baseUserManipulator
     *
     * @var FOS\UserBundle\Util\UserManipulator
     */
    private $baseUserManipulator;

    /**
     * User manager
     *
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager, $baseUserManipulator)
    {
        $this->userManager = $userManager;
        $this->baseUserManipulator = $baseUserManipulator;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string  $username
     * @param string  $password
     * @param string  $email
     * @param Boolean $active
     * @param Boolean $superadmin
     * @param string  $firstName
     * @param string  $lastName
     *
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $password, $email, $active, $superadmin, $firstName, $lastName)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setPlainPassword($password);
        $user->setEnabled((Boolean) $active);
        $user->setSuperAdmin((Boolean) $superadmin);
        $this->userManager->updateUser($user);

        return $user;
    }

    /**
     * Activates the given user.
     *
     * @param string $username
     */
    public function activate($username)
    {
        return $this->baseUserManipulator->activate($username);
    }

    /**
     * Deactivates the given user.
     *
     * @param string $username
     */
    public function deactivate($username)
    {
        return $this->baseUserManipulator->deactivate($username);
    }

    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password)
    {
        return $this->baseUserManipulator->changePassword($username, $password);
    }

    /**
     * Promotes the given user.
     *
     * @param string $username
     */
    public function promote($username)
    {
        return $this->baseUserManipulator->promote($username);
    }

    /**
     * Demotes the given user.
     *
     * @param string $username
     */
    public function demote($username)
    {
        return $this->baseUserManipulator->demote($username);
    }

    /**
     * Adds role to the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return Boolean true if role was added, false if user already had the role
     */
    public function addRole($username, $role)
    {
        return $this->baseUserManipulator->addRole($username, $role);
    }

    /**
     * Removes role from the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return Boolean true if role was removed, false if user didn't have the role
     */
    public function removeRole($username, $role)
    {
        return $this->baseUserManipulator->removeRole($username, $role);
    }
}