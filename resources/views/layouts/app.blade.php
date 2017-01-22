<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tweets</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
  
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<style>

    html {
      position: relative;
      min-height: 100%;
    }

    body {
      /* Margin bottom by footer height */
      margin-bottom: 60px;
    }

    .footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      /* Set the fixed height of the footer here */
      height: 60px;
      background-color: #f8f8f8;
    }  

    .tweet {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
            }

     .back-to-top {
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
        display:none;
    }       

</style>

</head>

<body id="app-layout">
    
    <nav class="navbar navbar-default navbar-fixed-top">
          
        <div class="container">
            <div class="navbar-header">
           
                
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                   Tweets   
                </a>

            </div>

          
        </div>
    </nav>
    
     
     @yield('content')

<footer class="footer">
      <div class="container">
        <p><strong>Copyright © 2017 <a href="/">Tweets</a> (beta version)</strong></p>
      </div>
</footer>
<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script>
function executeQuery() 
{
     var firstId = $('#firstId').val();
        $.ajax({
          url: '/new/'+firstId,
          beforeSend: function(){
                       $("#loaderDiv").show();
                       $("#loaderDiv").removeClass('hidden');
                       $('#text').text('Automatic update every 10 seconds');
                   },
          success: function(data) {
           if ((data.content)&&(data.firstTweetId)) {  
               
             var content =  data.content;  
             var id =  data.firstTweetId+''; 
             
               $( ".tweet-list" ).prepend(content);
               $('#firstId').val(id);
               $('#text').text('Automatic update every 10 seconds - New tweets was loaded.');
               $("#loaderDiv").hide();
               $("#loaderDiv").addClass('hidden');
 
            } else {
              $('#text').text('Automatic update every 10 seconds - No new tweets.');
               $("#loaderDiv").hide();
               $("#loaderDiv").addClass('hidden');  
            }
        },
        error: function(data) {
            $("#loaderDiv").hide(); 
            $("#loaderDiv").addClass('hidden');
            $('#text').text('Automatic update every 10 seconds - Loading Error.');
        }
      });
      setTimeout(executeQuery, 10000);
}

 var loaded = false;
 
 function loadMore(lastId) 
 { 
     $.ajax({
      url: '/load/'+lastId,
      success: function(data) {

      if ((data.content)&&(data.lastTweetId)) {   
         var content =  data.content;  
         var id =  data.lastTweetId+''; 

         $( ".tweet-list" ).append(content);
         $('#lastId').val(id);
         loaded = false;  
        } 
    } 
  });
}
  
$(function () {
      
        $(window).scroll(function () {
            
            if ($(this).scrollTop() > 60) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
   $('#back-to-top').tooltip('show');       
      
   setTimeout(executeQuery, 10000); 
   
        $(document).scroll(function (e) {
            // grab the scroll amount and the window height
            var scrollAmount = $(window).scrollTop();
            var documentHeight = $(document).height();
            // calculate the percentage the user has scrolled down the page
            var scrollPercent = (scrollAmount / documentHeight) * 100;
            
            if ((scrollPercent > 50) && (!loaded)) {
                // run a function called doSomething
                loaded = true;
                var lastId = $('#lastId').val();
                loadMore(lastId);
            } 
        });

    });
</script>

{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Up" data-toggle="tooltip" data-placement="left">
    <span class="glyphicon glyphicon-chevron-up"></span>
</a>

</body>
</html>

