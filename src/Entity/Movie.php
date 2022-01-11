<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(min=2, max=128)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(protocols={"http", "https"}, message="mmm ? what's that ?")
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Choice(choices={"France", "England", "Spain"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $rated;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\LessThanOrEqual(100)
     */
    private $price = 0.0;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="movies")
     * @Assert\Count(min=1)
     */
    private $genres;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRated(): ?string
    {
        return $this->rated;
    }

    public function setRated(string $rated): self
    {
        $this->rated = $rated;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function setGenres(ArrayCollection $genres)
    {
        $this->genres = $genres;
    }

    public function getGenreNames() : ?string
    {
        $string = '';
        foreach ($this->genres as $genre) {
            $string .= $genre->getName();
            $string .= ' ,';
        }
        return $string;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    public static function fromArrayInfos(array $infos, ?ArrayCollection $genres): self 
    {
        $movie = new self;
        $movie->setTitle($infos['Title']);
        $movie->setCountry($infos['Country']);
        $movie->setDescription("some description");
        $movie->setPoster($infos['Poster']);
        $movie->setRated($infos['Rated']);
        $movie->setPrice(random_int(0, 100));

        if ($genres) {
            $movie->setGenres($genres);
        }

        return $movie;
    }
}
