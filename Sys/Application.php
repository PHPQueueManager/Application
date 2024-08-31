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

        $helpers = array_merge($this->scanFiles(APP_DIR . 'Helpers'), $this->scanFiles(SYS_DIR . 'Helpers'));
        foreach ($helpers as $helper) {
            require_once $helper;
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $console = new \Symfony\Component\Console\Application(APP_NAME, APP_VERSION);

        $sysCommands = $this->scanFiles(SYS_DIR . 'Commands');
        foreach ($sysCommands as $sysCommand) {
            $commandClass = '\\Sys\\Commands\\' . str_replace([SYS_DIR . 'Commands' . DIRECTORY_SEPARATOR, '.php', '/'], ['', '', '\\'], $sysCommand);
            if (!class_exists($commandClass)) {
                continue;
            }
            $console->add(new $commandClass());
        }

        $appCommands = $this->scanFiles(APP_DIR . 'Commands');
        foreach ($appCommands as $appCommand) {
            $commandClass = '\\App\\Commands\\' . str_replace([APP_DIR . 'Commands' . DIRECTORY_SEPARATOR, '.php', '/'], ['', '', '\\'], $appCommand);
            if (!class_exists($commandClass)) {
                continue;
            }
            $console->add(new $commandClass());
        }

        $console->run();
    }


    private function scanFiles(string $directory, string $extension = 'php'): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $extension) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }


}
