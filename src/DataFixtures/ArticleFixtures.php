<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{


     public function __construct(Slugify $slugify)
    {
        $this->slug = $slugify;
    }


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');


            // Créer 50 articles
            for ($j=1; $j <= 50 ; $j++) {
                $article = new Article();

                $content = '<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>';

                $article->setTitle(mb_strtolower($faker->sentence()))
                        ->setContent($content)
                        ->setCategory($this->getReference('category_' . rand(0,4)));
                $article->setSlug($this->slug->generate($article->getTitle()));
                $manager->persist($article);

            }

        $manager->flush();
    }


    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

}
