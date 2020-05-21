<?php

namespace App\Command;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class ImageDeleteCommand extends Command
{
    protected static $defaultName = 'image:delete';

    // Expose the EntityManager in the class level
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;

        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setDescription('This Command delete images older than a provided number of months. <fg=yellow>[default : 1]</>')
            ->addArgument('months', InputArgument::OPTIONAL, 'How many months ago')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('months');
        // delete images older than 1 month by default
        $default=1;

        if ($arg1) {
            $io->note(sprintf('Will delete images older than %s Months', $arg1));
        }
        else
            $io->note(sprintf('Will delete images older than %s Month', $default));

        // Query for images
        $arg1?$months=$arg1:$months=$default;
        $images = $this->entityManager
            ->getRepository(Image::class)
            ->createQueryBuilder('img')
            ->where("img.deletedAt < :olderThan")
            ->setParameter("olderThan", new \DateTime('-'.$months.' months'))
            ->getQuery()
            ->getResult();
        if($images)
        {
        // Save id & url in two different arrays
        for($i=0;$i<count($images);$i++)
        list($id[], $url[]) = explode(":", $images[$i]);
        // Remove files from path
        $filesystem = new Filesystem();
        $progressBar = new ProgressBar($output, count($images));
        for($i=0;$i<count($url);$i++)
        {
            $filesystem->remove("./public/images/$url[$i]");
            //usleep(1500000);
            $progressBar->advance();
        }
            $progressBar->finish();
        // Query to delete fields older Than 1 month
        foreach ($images as $image) {
            $this->entityManager->remove($image);
        }
        $this->entityManager->flush();
        $output->writeln([
            '',
            '',
        ]);
        $io->success('Old images have been deleted.');
        }else
        $io->error('No old images have been Found.');

        return 0;
    }
}
