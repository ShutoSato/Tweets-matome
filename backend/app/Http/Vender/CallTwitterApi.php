<?php

namespace App\Http\Vender;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

class callTwitterApi
{
    private $twitterApi;
    
    public function __construct(){
        $this->twitterApi = new TwitterOAuth(
            config('twitter.CONSUMER_KEY'), 
            config('twitter.CONSUMER_SECRET'), 
            config('twitter.ACCESS_TOKEN'), 
            config('twitter.ACCESS_TOKEN_SECRET'),
        );
    }
    
    //oEmbed互換形式で取得
    public function statusesOembed(String $id){
        $tweet = $this->twitterApi->get("statuses/oembed", [
            'id' => $id,
        ]);
        return $tweet->html;
    }
    //RT数取得
    public function statusesShowRT(String $id){
        $tweetRT = $this->twitterApi->get("statuses/show/".$id);
        return $tweetRT->retweet_count;
    }
    //いいね数取得
    public function statusesShowFav(String $id){
        $tweetFav = $this->twitterApi->get("statuses/show/".$id);
        return $tweetFav->favorite_count;
    }
}