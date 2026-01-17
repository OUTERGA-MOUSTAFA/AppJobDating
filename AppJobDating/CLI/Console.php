<?php
namespace App\cli\commands;

class Console
{
    protected array $argv;
    protected array $commands = [];

    public function __construct(array $argv)
    {
        $this->argv = $argv;

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        // $this->commands = [
        //     'make:controller' => \App\cli\commands\MakeController::class,
        //     'make:middleware' => \App\cli\commands\MakeMiddleware::class,
        //     'serve' => \App\cli\commands\ServeCommand::class,
        // ];
    }

    public function run()
    {
        $commandName = $this->argv[1] ?? null;

        if (!$commandName || !isset($this->commands[$commandName])) {
            echo "Command not found ❌\n";
            exit;
        }

        $commandClass = $this->commands[$commandName];
        $command = new $commandClass();

        $command->handle(array_slice($this->argv, 2));
    }
}
