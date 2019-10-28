<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategoryData() as [$name]) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }
        $manager->flush();
    }

    private function getCategoryData()
    {
        return [
            ['Kriminalai', 1],
            ['Technologijos', 2],
            ['Sveikata', 3],
            ['Automobiliai', 4],
        ];
    }
}
