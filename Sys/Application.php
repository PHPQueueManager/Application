<?php

namespace Sys;

use Symfony\Component\Dotenv\Dotenv;

class Application
{
    public function __construct()
    {
    }

    public function boot(): self
    {
        is_file(ROOT_DIR . '.env') && (new Dotenv())->load(ROOT_DIR . '.env');

        $helpers = glob(APP_DIR . "Helpers/*.php");
        foreach ($helpers as $helper) {
            if (file_exists($helper)) {
                require_once $helper;
            }
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $console = new \Symfony\Component\Console\Application("Bulutklinik CLI", "1.0");
        $commands = glob(APP_DIR . "Commands/*.php");
        foreach ($commands as $command) {

            $commandClass = '\\App\\Commands\\' . basename($command, '.php');
            if (!class_exists($commandClass)) {
                continue;
            }
            $console->add(new $commandClass());
        }
        $console->run();
    }

}
