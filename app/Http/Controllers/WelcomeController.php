<?php

namespace App\Http\Controllers;

use Twitter;

/*
|--------------------------------------------------------------------------
| WelcomeController
|--------------------------------------------------------------------------
|
| This controller parsed tweets with official Twitter Api
| Controller have methods for lazy load tweets and 
| autorefresh for get new tweets
|
*/

class WelcomeController extends Controller
{   
   /**
   * Twitter User account name
   *
   * @var acc
   */
   protected $acc;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->acc = 'ukrpravda_news'; 
        #$this->acc = 'DenDenovskiy'; 
    }
    
    /**
     * Show main tweets on welcome page
     * 
     * @return Response
     */
    public function index()
    {
        $tweets = Twitter::getUserTimeline(['screen_name' => $this->acc, 'count' => 10, 'format' => 'array']);
        #print_r($tweets);
        $lastTweet = array_last($tweets);
        $firstTweet = array_first($tweets);
        $lastTweetId = $lastTweet['id'];
        $firstTweetId = $firstTweet['id'];
      
        return view('welcome', compact('tweets', 'lastTweetId', 'firstTweetId')); 
    }
    
    /**
     * Load more tweets by scroll down (lazy load)
     * 
     * @param int $id
     * @return Array
     */
    public function loadMore($id)
    {

        $loadTweets = Twitter::getUserTimeline(['screen_name' => $this->acc, 'max_id' => $id, 'count' => 11, 'format' => 'array']);
        
        $lastTweetLoad = array_last($loadTweets);
        unset($loadTweets[0]);
        $lastTweetId = $lastTweetLoad['id'];
        
        $loadedTweets = view('tweets.tweet', ['tweets' => $loadTweets]);
        $content = $loadedTweets->render(); 
        
        return ['content' => $content, 'lastTweetId' => $lastTweetId];
    }
    
     /**
     * Methow for AutoLoad new tweets 
     * 
     * @param int $id
     * @return Array
     */
    public function loadNew($id)
    {
        $loadTweets = Twitter::getUserTimeline(['screen_name' => $this->acc, 'since_id' => $id, 'count' => 10, 'format' => 'array']);

        if (! count($loadTweets)) { 
             return ''; 
        } 
         
        $firstTweetId = (string) $loadTweets[0]['id'];
      
        $loadedTweets = view('tweets.tweet', ['tweets' => $loadTweets, 'class' => 'new']);
        $content = $loadedTweets->render(); 
        
        return ['content' => $content, 'firstTweetId' => $firstTweetId]; 
    }
}
