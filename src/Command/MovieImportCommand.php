<?php

namespace App\Command;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieImportCommand extends Command
{
    protected static $defaultName = 'MovieImportCommand';
    protected static $defaultDescription = 'Import data from OMDB api';

    private MovieRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(MovieRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputOption::VALUE_REQUIRED, 'The movie title')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->title("Importing a movie from OMDB");
        $title = $input->getArgument('title');

        fetch:
        $movie = $this->repo->findMovieByTitleFromApi($title);
            if(!$movie->getTitle()) {
                $io->error("This movie does not exist");
                if ($io->ask("Provide another title?")) {
                    goto fetch;
                }
                $io->info("bye");
                return Command::SUCCESS;
            }

            $this->em->persist($movie);
            $this->em->flush();
            $io->info(sprintf("Title '%s' has been added", $title));

        return Command::SUCCESS;
    }
}
