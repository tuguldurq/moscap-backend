<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\UsersImport;
use App\Imports\ArtistSongsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import user data and artist songs from excel.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $type = $this->argument('type');
            if($type === 'user'){
                $this->info("Хуулж эхэлсэн... \n");
                $usersFilePath = storage_path('app/public/import/users.xlsx');
                (new UsersImport)->withOutput($this->output)->import($usersFilePath);
                $this->info('Хуулж дууслаа.');
            }else{
                $this->info("Хуулж эхэллээ... \n");
                $songsFilePath = storage_path('app/public/import/songs_06_09.xlsx');
                (new ArtistSongsImport)->withOutput($this->output)->import($songsFilePath);
                $this->info('Хуулж дууслаа.');
            }
            
        } catch (\Throwable $th) {
            $this->error('Алдаа гарлаа: '.$th->getMessage());
        }
    }
}
