<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BlogPostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getBlogPostData() as [$title, $subject, $category, $image, $author]) {
            $cat = $manager->getRepository(Category::class)->find($category);
            $auth = $manager->getRepository(User::class)->find($author);
            $post = new BlogPost();

            $post->setTitle($title);
            $post->setSubject($subject);
            $post->setCategory($cat);
            $post->setImagePath($image);
            $post->setImageTitle('title');
            $post->setAuthor($auth);
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getBlogPostData()
    {
        return [
            [
                'Savaitgalį į avarijas pateko ir policininkė, ir kariškis, ir daug kelių erelių',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                1,
                '/uploads/blog_post/images/kriminalai1.jpg',
                1
            ],
            [
                'Pareigūnai prašo visuomenės pagalbos ‒ atpažinti vaizdo kamerų užfiksuotus vyrus',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                1,
                '/uploads/blog_post/images/kriminalai2.jpg',
                2
            ],
            [
                'Rinkai pristatytas naujasis „Segway-Ninebot“ elektrinis paspirtukas įveikia 65 km atstumą',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                2,
                '/uploads/blog_post/images/34.jpg',
                1
            ],
            [
                'VR akiniai ir žaidimų konsolės: kokios yra naujausios tendencijos?',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                2,
                '/uploads/blog_post/images/44.jpg',
                2
            ],
            [
                '2 iš 3 lietuvių skundžiasi pablogėjusia sveikata prasidėjus šildymo sezonui: priežastis paprasta',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                3,
                '/uploads/blog_post/images/19.jpg',
                4
            ],
            [
                'Dermatologės patarimai: ką daryti, kad ūkanotas dangus džiugintų?',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                3,
                '/uploads/blog_post/images/97.jpg',
                2
            ],
            [
                '„Formulės 1“ titulo klausimas beveik išspręstas',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                4,
                '/uploads/blog_post/images/47.jpg',
                1
            ],
            [
                'Dakaras Saudo Arabijoje: penki absurdiški šios šalies įstatymai',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                4,
                '/uploads/blog_post/images/10.jpg',
                3
            ],

        ];

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
