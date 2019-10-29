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
        foreach ($this->getUserData() as [$firstName, $last_name, $email, $description,  $password, $roles]) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setAuthorDescription($description);

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
            ['Arturas', 'Bespalovas', 'artazzs@yahoo.com',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aspernatur 
                debitis delectus deleniti distinctio eaque earum enim eum ex expedita fugiat fugit hic 
                in ipsam iste labore laborum libero molestias nam neque nesciunt nostrum nulla numquam odio officia 
                officiis omnis praesentium provident, quisquam reiciendis repellendus soluta ullam vel vero vitae voluptate! Architecto, 
                asperiores aut commodi earum ex, expedita fugit laudantium libero nemo nesciunt, non obcaecati odio qui recusandae similique
                 ullam voluptate? Ab amet beatae, consequuntur corporis deleniti dicta dolor dolores doloribus, dolorum est eum explicabo facilis illo
                  ipsam iste itaque iusto labore libero magnam nam nesciunt omnis pariatur rem sed ullam velit veniam vero? Aliquam asperiores, assumenda
                   consequuntur dignissimos explicabo hic ipsum iste laboriosam omnis perferendis, provident, sequi tempora voluptates? Aspernatur consectetur
                    dicta eveniet magnam minus neque placeat quisquam ut vel vitae! Accusantium ad amet atque autem consequatur dicta dolores ex incidunt inventore 
                    laborum laudantium molestiae, numquam odio placeat porro recusandae rem sequi soluta temporibus totam veniam veritatis voluptate voluptatem? Deleniti
                     doloribus eligendi harum minima molestias nulla quibusdam quos tenetur totam unde. Ad assumenda autem earum, eos,
                 et facilis neque nesciunt porro possimus quasi reprehenderit sapiente sequi tempore. Alias aspernatur atque deserunt est hic ipsum nobis quisquam quod velit.',
                'kaskas', ['ROLE_ADMIN','ROLE_USER']],
            ['Juozas', 'Juozaitis', 'juozas@gmail.com',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aspernatur 
                debitis delectus deleniti distinctio eaque earum enim eum ex expedita fugiat fugit hic 
                in ipsam iste labore laborum libero molestias nam neque nesciunt nostrum nulla numquam odio officia 
                officiis omnis praesentium provident, quisquam reiciendis repellendus soluta ullam vel vero vitae voluptate! Architecto, 
                asperiores aut commodi earum ex, expedita fu.',
                'test',['ROLE_USER']],
            ['Petras', 'Petraitis', 'petras@gmail.com',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aspernatur 
                debitis delectus deleniti distinctio eaque earum enim eum ex expedita fugiat fugit hic 
             erendis, provident, sequi tempora voluptates? Aspernatur consectetur
                    dicta eveniet magnam minus neque placeat quisquam ut vel vitae! Accusantium ad amet atque autem consequatur dicta dolores ex incidunt inventore 
                    laborum laudantium molestiae, numquam odio placeat porro recusandae rem sequi soluta temporibus totam veniam veritatis voluptate voluptatem? Deleniti
                     doloribus eligendi harum minima molestias nulla quibusdam quos tenetur totam unde. Ad assumenda autem earum, eos,
                 et facilis neque nesciunt porro possimus quasi reprehenderit sapiente sequi tempore. Alias aspernatur atque deserunt est hic ipsum nobis quisquam quod velit.',
                'test',['ROLE_USER']],
            ['Jonas', 'Jonaitis', 'jonas@gmail.com',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aspernatur 
              ehenderit sapiente sequi tempore. Alias aspernatur atque deserunt est hic ipsum nobis quisquam quod velit.',
                'test',['ROLE_USER']],
            ['Akolegija', 'Testas', 'test@test.lt',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aspernatur 
                debitis delectus deleniti distinctio eaque earum enim eum ex expedita fugiat fugit hic 
                in ipsam iste labore laborum libero molestias nam neque nesciunt nostrum nulla numquam odio officia 
                officiis omnis praesentium provident, quisquam reiciendis repellendus soluta ullam vel vero vitae voluptate! Architecto, 
                asperiores aut commodi earum ex, expedita fugit laudantium libero nemo nesciunt, non obcaecati odio qui recusandae similique
                 ullam voluptate? Ab amet beatae, consequuntur corporis deleniti dicta dolor dolores doloribus, dolorum est eum explicabo facilis illo
                  ipsam iste itaque iusto labore libero magnam nam nesciunt omnis pariatur rem sed ullam velit veniam vero? Aliquam asperiores, assumenda
                   consequuntur dignissimos explicabo hic ipsum iste laboriosam omnis perferendis, provident, sequi tempora voluptates? Aspernatur consectetur
                    dicta eveniet magnam minus neque placeat quisquam ut vel vitae! Accusantium ad amet atque autem consequatur dicta dolores ex incidunt inventore 
                    laborum laudantium molestiae, numquam odio placeat porro recusandae rem sequi soluta temporibus totam veniam veritatis voluptate voluptatem? Deleniti
                     doloribus eligendi harum minima molestias nulla quibusdam quos tenetur totam unde. Ad assumenda autem earum, eos,
                 et facilis neque nesciunt porro possimus quasi reprehenderit sapiente sequi tempore. Alias aspernatur atque deserunt est hic ipsum nobis quisquam quod velit.',
                'test', ['ROLE_ADMIN','ROLE_USER']],
        ];
    }
    public function getDependencies()
    {
        return array(
            CategoryFixtures::class
        );
    }
}
