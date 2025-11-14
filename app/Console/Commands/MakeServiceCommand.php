<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';


    /**
     * The console command description.
     *
     * @var string
     */

     protected $description = 'Create a new service class';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . $name . '.php');

        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

        // Ensure Services directory exists
        if (!File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        $stub = <<<EOT
        <?php

        namespace App\Services;

        class {$name}{

            public function __construct()
            {
                //
            }
        }
        EOT;

        File::put($servicePath, $stub);

        $this->info("Service created: App\\Services\\{$name}");
    }
}
