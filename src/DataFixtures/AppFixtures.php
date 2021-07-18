<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\Language;
use App\Entity\Meal;
use App\Entity\Status;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $languages = ['hr', 'fr', 'de'];

        foreach ($languages as $language) {
            $lang = new Language();
            $lang->setCode($language);
            $lang->setName($language . '_lang');
            if ($language == 'hr') {
                $lang->setIsDefault(true);
            }
            $manager->persist($lang);
            $manager->flush();
        }

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setSlug($faker->slug);
            $manager->persist($category);
            $categories[] = $category;

            foreach ($languages as $language) {
                $category->setLocale($language);
                $category->setTitle('Naslov kategorije ' . $i . ' na ' . $language . ' jeziku');
                $manager->persist($category);
                $manager->flush();
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setSlug($faker->slug);
            $manager->persist($ingredient);
            $ingredients[] = $ingredient;

            foreach ($languages as $language) {
                $ingredient->setLocale($language);
                $ingredient->setTitle('Naslov sastojka ' . $i . ' na ' . $language . ' jeziku');
                $manager->persist($ingredient);
                $manager->flush();
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag->setSlug($faker->slug);
            $manager->persist($tag);
            $tags[] = $tag;

            foreach ($languages as $language) {
                $tag->setLocale($language);
                $tag->setTitle('Naslov taga ' . $i . ' na ' . $language . ' jeziku');
                $manager->persist($tag);
                $manager->flush();
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $meal = new Meal();
            $meal->setStatus('created');
            $status = new Status();
            $manager->persist($status);
            $meal->addStatus($status);
            $meal->setCategory($categories[$i]);
            $meal->addIngredient($ingredients[$i]);
            $meal->addTag($tags[$i]);
            $manager->persist($meal);
            foreach ($languages as $language) {
                $meal->setLocale($language);
                $meal->setTitle('Naslov jela na ' . $language . ' jeziku');
                $meal->setDescription('Opis jela na ' . $language . ' jeziku');
                $manager->persist($meal);
                $manager->flush();
            }

            //Safe deleting test
            if ($i % 2 == 0) {
                $manager->remove($status);
                $meal->setStatus('deleted');
                $manager->persist($meal);
            }
        }
    }
}
