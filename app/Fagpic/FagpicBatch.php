<?php

namespace App\Fagpic;

use Illuminate\Support\Facades\Log;

class FagpicBatch
{
    public function run()
    {
        Log::debug('run() start');
        
        Log::debug('run() complete!');
    }
}
