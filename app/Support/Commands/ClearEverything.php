<?php namespace App\Support\Commands;

use Illuminate\Console\Command;

class ClearEverything extends Command
{
    protected $signature = 'koderlabs:clear-everything';

    protected $description = 'Clears routes, config, cache, views, compiled, and caches config.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $validCommands = array('route:clear', 'cache:clear', 'view:clear', 'clear-compiled', 'config:clear', 'config:cache');

        foreach ($validCommands as $cmd) {
            $this->call('' . $cmd . '');
        }

        print_r('Application cache cleared!');
    }
}
