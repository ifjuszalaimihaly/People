<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>@yield('title')</title>
  <!-- Bootstrap -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet"> 
  </head>
  <body>

  <nav class="navbar navbar-default fixed-top">
  <div class="container-fluid">
  <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li {{ Route::currentRouteName()== 'person.create' ? 'class=active' : '' }}><a href="{{ route('person.create') }}">Új személy felvétele<span class="sr-only">(current)</span></a>
        </li>

        
        <li {{ Route::currentRouteName()== 'person.index' ? 'class=active' : '' }}><a href="{{ route('person.index') }}">Személyek listázása<span class="sr-only">(current)</span></a>
        </li>

     
        

       
      </ul>
  </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        var personId ="";
        var bossId =""
        $('#confirmDelete').on('show.bs.modal', function(e) {
            personId = $(e.relatedTarget).data('pesron_id');
            var personName = $(e.relatedTarget).data('person_name');
            bossId = $(e.relatedTarget).data('pesron_boss_id');
            //alert(bossId);
            $("#confirmDelete #pName").text(personName);
            /*console.log(personId);
            console.log(personName);*/
        });
        $("#delete").click(function(event) {
          var token = $('input[name=_token]').val();
          $.ajax({
            url: 'person/delete',
            type: 'post',
            data: {_token: token, _method: 'delete', id: personId},
          })
          .done(function() {
            $("#li-" + personId).fadeOut();
            $.ajax({
              url: 'person/'+bossId+'/countsublatern',
              type: 'get'
            })
            .done(function(countsublatern) {
              if(countsublatern == 0){
                $("#del-"+bossId).show();
              }
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
            
            //console.log("success");
          })
          .fail(function(result) {
            console.log(result);
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
        });
        $('#showBigImage').on('show.bs.modal', function(e) {
          var personName = $(e.relatedTarget).data('person_name');
          $("#showBigImage #pName").text(personName);
          var src = $(e.relatedTarget).data('pesron_big_image');
          $("#imagepreview").attr('src',src);
        });
      }); 
      $(document).on('click','.btn-photo',function(event) {
        personId = event.target.id.substr(4);
        var token = $('input[name=_token]').val();
        $.ajax({
          url: 'image/destroy',
          type: 'post',
          data: {_token: token, _method: 'delete', id: personId},
        })
        .done(function() {
          $("#img-"+personId).fadeOut();
          $("#btn-"+personId).fadeOut();
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
      });     
    </script>
@yield('content')
   
    
  </body>
  </html>