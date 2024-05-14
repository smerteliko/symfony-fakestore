<?php

namespace App\Command;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-sub-cat',
    description: 'Sub category creation',
)]
class CreateSubCatCommand extends Command
{
    private CategoryRepository $categoryRepository;
    private SubCategoryRepository $subCategoryRepository;

    public function __construct(CategoryRepository $categoryRepository,
        SubCategoryRepository $subCategoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('Name', InputArgument::REQUIRED, 'Sub Category name')
            ->addArgument('CategoryID', InputArgument::REQUIRED, 'Sub Category description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $data = [
            'Name' => $input->getArgument('Name'),
            'Category' => $this->categoryRepository->find((int) $input->getArgument('CategoryID')),
        ];
        $this->subCategoryRepository->newSubCategory($data);

        $io->success('Sub Category created successfully');

        return Command::SUCCESS;
    }
}
