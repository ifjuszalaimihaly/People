$(document).ready(function() {
	var personId = $("#personid").val();
	alert(personId);
	$("#email").blur(function(event) {
	  
	  alert("blur");
	});
});


