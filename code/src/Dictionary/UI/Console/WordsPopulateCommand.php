<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Console;

use App\Dictionary\Application\Assert\FileAssert;
use App\Dictionary\Application\Dto\WordsStoragePopulateCriteria;
use App\Dictionary\Application\Service\WordsStoragePopulate;
use App\Shared\UI\Console\AbstractCommand;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

final class WordsPopulateCommand extends AbstractCommand
{
    protected static $defaultName = 'crossword:dictionary:words-storage-populate';

    private string $filePath;
    private array $dictionaryList;
    private WordsStoragePopulate $wordsStoragePopulate;

    public function __construct(WordsStoragePopulate $wordsStoragePopulate, array $dictionaryList)
    {
        parent::__construct();

        $this->wordsStoragePopulate = $wordsStoragePopulate;
        $this->dictionaryList = $dictionaryList;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Populate a new words to the storage')
            ->addArgument('language', InputArgument::REQUIRED, 'Language code')
            ->addOption('file-path', null, InputOption::VALUE_OPTIONAL, 'File path')
            ->setHelp(
                <<<HELP
The command populate a new words to the storage 
    <info>php %command.full_name% ua</info>
    <info>php %command.full_name% ua --file-path=file.txt</info>
HELP
            );
    }

    protected function doExecute(InputInterface $input, SymfonyStyle $io): void
    {
        $criteria = new WordsStoragePopulateCriteria((string) $input->getArgument('language'), $this->filePath);
        $count = $this->wordsStoragePopulate->execute($criteria);

        $io->info(sprintf('Populate %s words', $count));
    }

    protected function validateInput(InputInterface $input): void
    {
        if ($this->filePath = (string) $input->getOption('file-path')) {
            FileAssert::assertTxtFile($input->getOption('file-path'));

            return;
        }

        if (!array_key_exists($input->getArgument('language'), $this->dictionaryList)) {
            throw new RuntimeException('Dictionary is not found for words populate.');
        }

        $this->filePath = $this->dictionaryList[$input->getArgument('language')];
    }
}