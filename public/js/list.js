$(document).ready(function() {
  var personId ="";
  var bossId =""
  $('#confirmDelete').on('show.bs.modal', function(e) {
      personId = $(e.relatedTarget).data('pesron_id');
      var personName = $(e.relatedTarget).data('person_name');
      bossId = $(e.relatedTarget).data('pesron_boss_id');
      $("#confirmDelete #pName").text(personName);
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
}); 