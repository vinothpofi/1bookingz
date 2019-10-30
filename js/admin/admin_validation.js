 
$("#admin_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z\s]/g)) {
	   document.getElementById("name_error").style.display = "inline";
	   $("#name_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
   }
});

$("#email_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9-\s&]/g)) {
	   document.getElementById("site_name_error").style.display = "inline";
	   $("#site_name_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9-\s&]/g, ''));
   }
});

$("#twilio_phone_number").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   document.getElementById("twilio_phone_number_error").style.display = "inline";
	   $("#twilio_phone_number_error").fadeOut(5000);
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
});

$("#twilio_account_sid").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("twilio_account_sid_error").style.display = "inline";
	   $("#twilio_account_sid_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});


$("#twilio_account_token").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("twilio_account_token_error").style.display = "inline";
	   $("#twilio_account_token_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});

$("#home_title_1").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_1_error").style.display = "inline";
	   $("#home_title_1_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_2").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_2_error").style.display = "inline";
	   $("#home_title_2_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_3").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_3_error").style.display = "inline";
	   $("#home_title_3_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_4").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_4_error").style.display = "inline";
	   $("#home_title_4_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});