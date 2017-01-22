@extends('layouts.app')

@section('content')

<div class="container" style="margin-top:50px">
    
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <p>
                <img src="{{asset('/css/spinner.gif')}}" alt="Wait" style="margin-top: 20px;margin-right: 20px" height="35" width="35" class="hidden pull-right" id="loaderDiv">
                <h2 id="text">Automatic update every 10 seconds</h2>
            </p>

            <div class="tweet-list">
              @include('tweets.tweet', ['tweets' => $tweets])
            </div>
            
        </div>
        
    </div>
    
</div>

<input type="hidden" value="{{$lastTweetId}}" id="lastId"> 
<input type="hidden" value="{{$firstTweetId}}" id="firstId">     

@endsection