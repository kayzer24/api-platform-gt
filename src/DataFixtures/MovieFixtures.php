<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var array<array-key,Genre> $genres */
        $genres = $manager->getRepository(Genre::class)->findAll();

        /** @var array<array-key,Person> $people */
        $people = $manager->getRepository(Person::class)->findAll();

        foreach ($genres as $genre) {
            for ($i = 1; $i <= 10; $i++) {
                $movie = new Movie();
                $movie->setTitle(sprintf('Title %d', $i));
                $movie->setSynopsis(sprintf('Synopsis %d', $i));
                $movie->setDuration(rand(80, 300));
                $movie->setProductionYear(rand(1970, 2022));
                $movie->setGenre($genre);

                shuffle($people);

                foreach (array_slice($people, 0, 3) as $actor) {
                    $movie->getActors()->add($actor);
                }

                foreach (array_slice($people, 3, 2) as $director) {
                    $movie->getDirectors()->add($director);
                }

                $manager->persist($movie);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PersonFixtures::class,
            GenreFixtures::class
        ];
    }
}
