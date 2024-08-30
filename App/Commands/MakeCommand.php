<?php
namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use const PHP_EOL;

class MakeCommand extends Command
{

    protected static $defaultName = 'make:command';

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        $path = APP_DIR . "Commands/";

        if (str_contains($name, "/")) {
            $split = explode("/", $name);
            $name = array_pop($split);
            $path .= implode("/", $split) . "/";
        }
        $path .= $name . ".php";

        $status = @file_put_contents($path, strtr($this->commandString(), [
            '{class}'       => $name,
        ]));

        return $status ? Command::SUCCESS : Command::FAILURE;
    }

    public function configure(): void
    {
        $this->setDescription('Creates a new command!')
            ->addArgument('name', InputArgument::REQUIRED, 'Command Name')
            ->setHelp('');
    }

    private function commandString()
    {
        $str = '<?php' . PHP_EOL
            . 'namespace App\Commands;' . PHP_EOL
            . 'use \Symfony\Component\Console\Input\InputInterface;'. PHP_EOL
            . 'use \Symfony\Component\Console\Output\OutputInterface;' . PHP_EOL
            . 'use \Symfony\Component\Console\Command\Command;' . PHP_EOL . PHP_EOL
            . 'class {class} extends Command' . PHP_EOL
            . '{' . PHP_EOL . PHP_EOL
            . '    protected static $defaultName = "";' . PHP_EOL . PHP_EOL
            . '    public function execute(InputInterface $input, OutputInterface $output): int' . PHP_EOL
            . '    {' . PHP_EOL
            . '        return Command::SUCCESS;' . PHP_EOL
            . '    }' . PHP_EOL . PHP_EOL
            . '    public function configure(): void' . PHP_EOL
            . '    {' . PHP_EOL
            . '        $this->setDescription("");' . PHP_EOL
            . '    }' . PHP_EOL
            . PHP_EOL . '}' . PHP_EOL;

        return $str;
    }

}
