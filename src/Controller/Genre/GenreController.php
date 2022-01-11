<?php

namespace App\Controller\Genre;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="genre")
     */
    public function index(GenreRepository $repo): Response
    {
        $genres = $repo->findAllGenreNamesWithPosters();

        return $this->render('genre/index.html.twig', ['genres' => $genres]);
    }
}
