<?
namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetFilePermissions extends Command
{
    protected $signature = 'permissions:set';
    protected $description = 'Set default file and directory permissions';

    public function handle()
    {
        $paths = [
            storage_path('framework'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];

        foreach ($paths as $path) {
            exec("chmod -R 775 $path");
            exec("chown -R veroanalysis:veroanalysis $path");
        }

        $this->info('Permissions updated successfully!');
    }
}
