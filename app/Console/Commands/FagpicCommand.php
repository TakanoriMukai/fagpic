<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Fagpic\FagpicBatch as FagpicBatch;

class FagpicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fagpic:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $batch = new FagpicBatch;
        $batch->run();
    }
}
