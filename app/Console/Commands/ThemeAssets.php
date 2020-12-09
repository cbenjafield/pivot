<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class ThemeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates symbolic links for the theme folders.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->links() as $link => $target) {
            if(file_exists($link)) {
                $this->error("The [$link] link already exists.");
            } else {
                $this->laravel->make('files')->link($target, $link);

                $this->info("The [$link] has been connected to [$target]");
            }
        }

        $this->info('The links have been created.');

        return 1;
    }

    /**
     * Get the symbolic links that need to be created.
     * 
     * @return array
     */
    protected function links()
    {
        return [
            public_path('themes/drive247/images') => resource_path('themes/drive247/images'),
        ];
    }
}