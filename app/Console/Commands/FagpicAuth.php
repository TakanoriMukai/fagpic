<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Abraham\TwitterOAuth\TwitterOAuth;

class FagpicAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fagpic:auth';

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
        $conn = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret')
        );

        $content = $conn->get("search/tweets", ["q" => '#フレームアームズ・ガール filter:images -RT']);

        dd($content);

        /*
        foreach( $content->statuses as $status){
            print($status->created_at."\n");
            print($status->id."\n");
            print($status->text."\n");
            if( array_key_exists( 'media', $status->entities )){
                foreach( $status->entities->media as $m ){
                    print($m->url."\n");
                    print($m->expanded_url."\n");
                }
            }
            print($status->metadata->iso_language_code."\n");
            print($status->user->id."\n");
            print($status->user->name."\n");
            print($status->user->screen_name."\n");
        }
        */
    }
}
