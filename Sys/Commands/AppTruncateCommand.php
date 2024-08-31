<?php

namespace Sys\Commands;

use Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use const PHP_EOL;

class AppTruncateCommand extends Command
{

    protected static $defaultName = 'app:truncate';

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->deleteExcept(APP_DIR, [
            APP_DIR . "Queues",
            APP_DIR . "Messages",
            APP_DIR . "Helpers",
            APP_DIR . "Commands",
        ]);
        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription('Be Careful! This command completely empties the App directory.')
            ->setHelp('');
    }

    private function deleteExcept($dir, $except = []) {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            $filePath = $file->getPathname();

            if (in_array($filePath, $except)) {
                continue;
            }

            $file->isDir() ? rmdir($filePath) : unlink($filePath);
        }
    }

}
