<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Service\OmdbAPIService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{

    private OmdbAPIService $httpApi;
    private GenreRepository $genreRepository;

    public function __construct(ManagerRegistry $registry, OmdbAPIService $httpApi, GenreRepository $genreRepository)
    {
        parent::__construct($registry, Movie::class);
        $this->httpApi = $httpApi;
        $this->genreRepository = $genreRepository;
    }

    public function findLatest($limit = 5) : array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMovieByTitleFromApi(string $title): Movie
    {
        $data = $this->httpApi->fetchMovieByTitle($title);
        
        if (!$data) {
            return new Movie();
        }

        $genres = explode(',', $data['Genre']);
        $genres = $this->genreRepository->findBy(['name' => $genres]);

        $genres = new ArrayCollection($genres);

        return Movie::fromArrayInfos($data, $genres);
    }
}
