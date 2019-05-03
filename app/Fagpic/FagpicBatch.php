<?php

namespace App\Fagpic;

use Illuminate\Support\Facades\Log;
use App\Fagpic\TweetFetcher;
use App\Fagpic\TweetParser;
use App\Fagpic\HttpDownloader;
use App\Fagpic\TweetCollector;
use App\TwitterPicture;
use App\Fagpic\TwitterReporter;

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
        $dl_count = 0;

        Log::debug('fetch() start');
        $fetcher->fetch();
        Log::debug('     -> complete! '.count($fetcher->getTweetObject()->statuses).' tweets fetched.' );

        Log::debug('parse() start');
        $parser->parse( $fetcher->getTweetObject());
        Log::debug('     -> complete! '.count($parser->getUrls()).' urls detected.');

        Log::debug('collect() start');
        $res =  $collector->collect($parser->getData());

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
            $dl_count++;
        }
        Log::debug('        -> complete!');
        
        Log::debug('report() start');
        $reporter = new TwitterReporter(config('twitter.consumer_key'),
                                       config('twitter.consumer_secret'),
                                       config('twitter.access_token'),
                                       config('twitter.access_token_secret'));
        $report_text =  "画像収集[".date('Y-m-d H:i')."]の部、完了〜☆彡";
        if($res->new_tweet > 0)
        {
            $report_text = $report_text."\n結果は以下です。\n".
                        "－－－－－－－－－－－－－\n".
                        ' * 新規Tweet数: '.$res->new_tweet."件\n".
                        ' * 収集画像枚数: '.$res->url_count."枚\n".
                        ' * 新規Hashtag数: '.$res->new_tag."件\n";
        }
        else
        {
            $report_text = $report_text."\n新しい画像はなかったです。\n";
        }
        $res = $reporter->report($report_text);
        Log::debug('      -> '.$report_text);
        Log::debug('      -> '.json_encode($res));
        Log::debug('      -> complete!');

        Log::debug('run() complete!');
    }
}
