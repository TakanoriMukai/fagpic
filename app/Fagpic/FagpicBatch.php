<?php

namespace App\Fagpic;

use Illuminate\Support\Facades\Log;
use App\Fagpic\TweetFetcher;
use App\Fagpic\TweetParser;
use App\Fagpic\HttpDownloader;
use App\Fagpic\TweetCollector;

class FagpicBatch
{
    public function run()
    {
        
        $fetcher = new TweetFetcher(config('twitter.consumer_key'),
                                    config('twitter.consumer_secret'));
        $parser = new TweetParser();
        $collector = new TweetCollector();

        Log::debug('fetch() start');
        $fetcher->fetch();
        
        Log::debug('parse() start');
        $parser->parse( $fetcher->getTweetObject());

        Log::debug('collect() start');
        $collector->collect($parser->getData());

        Log::debug('run() complete!');
    }
}
