<?php

namespace App\Command;

use App\Repository\CategoryRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-cat',
    description: 'Category creation',
)]
final class AppCreateCatCommand extends Command
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('Name', InputArgument::REQUIRED, 'Category name')
            ->addArgument('Descr', InputArgument::OPTIONAL, 'Category description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $data = [
            'Name' => $input->getArgument('Name'),
            'Desc' => $input->getArgument('Descr'),
        ];
        $this->categoryRepository->newCategory($data);

        $io->success('Category created successfully');

        return Command::SUCCESS;
    }
}
