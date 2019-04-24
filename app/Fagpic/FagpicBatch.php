<?php

namespace App\Fagpic;

use Illuminate\Support\Facades\Log;
use App\Fagpic\TweetFetcher;
use App\Fagpic\TweetParser;
use App\Fagpic\HttpDownloader;
use App\Fagpic\TweetCollector;
use App\TwitterPicture;

class FagpicBatch
{
    public function run()
    {

        $fetcher = new TweetFetcher(config('twitter.consumer_key'),
                                    config('twitter.consumer_secret'));
        $parser = new TweetParser();
        $collector = new TweetCollector();
        $downloader = new HttpDownloader();
        $tpicture = new TwitterPicture();

        Log::debug('fetch() start');
        $fetcher->fetch();
        Log::debug('     -> complete! '.count($fetcher->getTweetObject()->statuses).' tweets fetched.' );

        Log::debug('parse() start');
        $parser->parse( $fetcher->getTweetObject());
        Log::debug('     -> complete! '.count($parser->getUrls()).' urls detected.');

        Log::debug('collect() start');
        $collector->collect($parser->getData());

        Log::debug('download() start');
        $urls = $tpicture
            ->whereNull('file_path')
            ->get();

        foreach($urls as $url)
        {
            $save_path = $downloader->download( $url->url, config('gcp.storage_path'));
            $full_path = config('gcp.storage_path').''.$save_path;
            $tpicture->where('url','=',$url->url)
                ->update(['file_path' => $save_path,'size' => filesize($full_path)]);
            Log::debug('        -> '.$save_path.' download complete. size: '.(Integer)(filesize($full_path)/1024).'KB');
        }
        Log::debug('        -> complete!');
        

        Log::debug('run() complete!');
    }
}
