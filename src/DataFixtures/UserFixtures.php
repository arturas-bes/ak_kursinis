<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$firstName, $last_name, $email, $password, $roles]) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $passw = $this->passwordEncoder->encodePassword($user, $password);

            $user->setPassword($passw);
            $user->setRoles($roles);
            $manager->persist($user);
        }
        $manager->flush();
    }
    private function getUserData(): array
    {
        return [
            ['Arturas', 'Bespalovas', 'artazzs@yahoo.com', 'kaskas', ['ROLE_ADMIN','ROLE_USER']],
            ['Juozas', 'Juozaitis', 'juozas@gmail.com', 'test',['ROLE_USER']],
            ['Petras', 'Petraitis', 'petras@gmail.com', 'test',['ROLE_USER']],
            ['Jonas', 'Jonaitis', 'jonas@gmail.com', 'test',['ROLE_USER']],
            ['Akolegija', 'Testas', 'test@test.lt', 'test', ['ROLE_ADMIN','ROLE_USER']],
        ];
    }
    public function getDependencies()
    {
        return array(
            CategoryFixtures::class
        );
    }
}
