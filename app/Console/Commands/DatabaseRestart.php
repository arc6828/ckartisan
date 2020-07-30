<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mylog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseRestart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:logrestart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a log when restart';

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
        if (Schema::hasTable('my_logs')) {
            Mylog::create([
                "title" => "Mysql Restart",
                "content" => "Mysql Restart by cronjob",
            ]);
        }
    }
}
