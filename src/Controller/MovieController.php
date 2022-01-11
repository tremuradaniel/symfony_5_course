<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/latest")
     */
    public function latest(MovieRepository $repo)
    {
        return $this->render('movie/latest.html.twig', ['movies' => $repo->findLatest()]);
    }
}

