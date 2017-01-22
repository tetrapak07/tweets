@foreach($tweets as $tweet)
<div class="tweet" @if(isset($class)) style="background-color:#f8f8f8;" @endif>
    
   <div class="media">
       
            <div class="media-left">
                @if (isset($tweet['user']['profile_image_url_https']))
                <img class="img-thumbnail media-object" src="{{ $tweet['user']['profile_image_url_https'] }}" alt="Avatar">
                @endif
            </div>
       
            <div class="media-body">
                
                 @if(isset($class))
                 <p class="pull-right green-new" style="color:green;">new</p>
                 @endif
                 
                 <h4 class="media-heading">
                     {{ '@' . $tweet['user']['screen_name'] }}
                     @if (isset($tweet['entities']['user_mentions']['0']['name'])) retweeted
                     <a target="_blank" href="https://twitter.com/{{$tweet['entities']['user_mentions']['0']['screen_name']}}">
                       {{$tweet['entities']['user_mentions']['0']['name']}}
                     </a>
                     @endif
                 </h4>
               
                <p>{{ $tweet['text'] }}</p>
                
                @if (isset($tweet['extended_entities']['media']))
                    @foreach($tweet['extended_entities']['media'] as $key => $media)
                    <img src="{{$media['media_url_https']}}" class="img-responsive" alt="Media">
                    @endforeach
                @endif
                
                <p>
                <a target="_blank" href="https://twitter.com/{{ $tweet['user']['screen_name']}}/status/{{ $tweet['id'] }}">
                    View on Twitter
                </a>
                </p>
            </div>
       
    </div>

</div>
@endforeach

