<?php

declare(strict_types=1);

namespace App\Command;

use App\Common\Parse\ParseFileInterface;
use App\Entity\Tender;
use App\Enum\TenderStatusEnum;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:tender-create',
    description: 'Create ',
)]
class TenderCreateFromFileCommand extends Command
{
    private const FILE = 'file';

    public function __construct(
        private readonly ParseFileInterface $parseFile,
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addOption(
            self::FILE,
            null,
            InputOption::VALUE_REQUIRED,
        );
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if(null === $input->getOption(self::FILE))
        {
            $io->error('Provide filename --file=');

            return Command::FAILURE;
        }

        $fileName = sprintf('/%s', $input->getOption(self::FILE));

        $parseResult = $this->parseFile->parse($fileName);

        $progress = new ProgressBar($io);
        $progress->start();

        foreach($parseResult as $i => $result)
        {

            $tender = new Tender();

            $tender->setTitle($result['Название']);
            $tender->setNumber($result['Номер']);

            $tender->setExternalCode($result['Внешний код'] ?? null);

            if($result['Статус'] || in_array($result['Статус'], TenderStatusEnum::VALUES))
            {
                $tender->setStatus(TenderStatusEnum::tryFrom($result['Статус']));
            }

            $tender->setUpdatedAt(new DateTimeImmutable($result['Дата изм.'] ?? 'now'));

            $this->entityManager->persist($tender);

            if(($i % 200) === 0)
            {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }

            $progress->advance();
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $progress->finish();

        $io->success("Tenders created successfully \n");

        return Command::SUCCESS;
    }
}
