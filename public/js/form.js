$(document).ready(function() {
	var personId = $("input[name=personid]").val();
	$("input[name=email]").blur(function(event) {
	  var email = $(this).val();
	  var APP_URL = '{!! json_encode(url('/')) !!}';
	  console.log(APP_URL);
	  $.ajax({
	    	url: 
	    	'person/emailcheck',
	    	type: 'get',
	  })
	  .done(function() {
	  	console.log("success");
	  })
	  .fail(function() {
	  	console.log("error");
	  })
	  .always(function() {
	  	console.log("complete");
	  });
	  
	});
});


