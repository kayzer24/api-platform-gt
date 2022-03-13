<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RandomMovieController extends AbstractController
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(): Movie
    {
        return $this->movieRepository->getRandomMovie();
    }
}
