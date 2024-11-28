<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetFilePermissions extends Command
{
    protected $signature = 'permissions:set';
    protected $description = 'Set default file and directory permissions';

	public function __construct()
    {
        parent::__construct();
    }
	
    public function handle()
    {
        $paths = [
            storage_path('framework'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];

        foreach ($paths as $path) {
            exec("sudo chmod -R 775 $path");
            exec("sudo chown -R veroanalysis:veroanalysis $path");
        }

        $this->info('Permissions updated successfully!');
    }
}
