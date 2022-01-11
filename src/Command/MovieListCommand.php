<?php

namespace App\Command;

use App\Repository\MovieRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieListCommand extends Command
{
    protected static $defaultName = 'app:movie:list';
    protected static $defaultDescription = 'List our movies';

    private const MAX_RESULTS = 5;

    private MovieRepository $repo;

    public function __construct(MovieRepository $r)
    {
        $this->repo = $r;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('max-results', null, InputOption::VALUE_OPTIONAL, 'max number of movies to dump', self::MAX_RESULTS)
            ->setHelp("The <info>%command.name%</info> helper")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $max = (int) $input->getOption('max-results');

        $data = $this->repo->createQueryBuilder('m')
            ->select('m.id', 'm.title')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getArrayResult()
            ;

        $io->title("Our list:");

        var_dump($data);

        $io->table(['id', 'title'], $data);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
