<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RunSqlOnProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Run Sql File After Migration Run On Production';

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
     * @return int
     */
	public function getAllFilesInFolder():array  {
		$fileNames = [];
		$path = app_path('Triggers/Cashvero');
		$files = \File::allFiles($path);
	
		foreach($files as $file) {
			array_push($fileNames, pathinfo($file)['filename']);
		}
		return $fileNames;
	}
    public function handle()
    {
		$fileNames=$this->getAllFilesInFolder();
		foreach($fileNames as $fileName){
			$fileContent = file_get_contents(app_path('Triggers/Cashvero').'/'.$fileName.'.sql');
			$fileContent = str_replace(array("delimiter ;","delimiter //","DELIMITER $$","delimiter $$","DELIMITER ;"), '', $fileContent);
			$fileContent = str_replace(['//','$$'],';',$fileContent);
			$fileContent = str_replace(['DELIMITER ;'],'',$fileContent);
			DB::unprepared(DB::raw($fileContent));
		}
    }
}
