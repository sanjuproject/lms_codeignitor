function check_verified_email_phone()
{
	var phone_v = $("#phone_verified").val();
	var email_v = $("#email_verified").val();
	if((phone_v == 0 || email_v == 0))
	{
		$('.verify').attr('disabled','disabled');
		if(email_v == 1)
		{
			$("#email_verify").hide();
		}
		if(phone_v == 1)
		{
			$("#phone_verify").hide();
		}
	}
	else
	{
		if(email_v == 1)
		{
			$("#email_verify").hide();
		}
		if(phone_v == 1)
		{
			$("#phone_verify").hide();
		}
		$('.verify').removeAttr('disabled');
	}
}
function checkemail(value)
{
	var old_email = $("#old_email").val();
	var userid = $("#userid").val();
	if(old_email != value)
	{
		$("#email_verified").val(0);
		check_verified_email_phone();
		$("#email_verify").css('display','block');
	}
	else
	{
		$("#email_verified").val(1);
		check_verified_email_phone();
		$("#email_verify").css('display','none');
	}
}

function checkphone(value)
{
	var old_phone = $("#old_phone").val();
	var userid = $("#userid").val();
	if(old_phone != value)
	{
		$("#phone_verified").val(0);
		check_verified_email_phone();
		$("#phone_verify").css('display','block');
	}
	else
	{
		$("#email_verified").val(1);
		check_verified_email_phone();
		$("#phone_verify").css('display','none');
	}
}
function sendverificationcode()
{
	var email = $("#email").val();
	var old_email = $("#old_email").val();
	var userid = $("#userid").val();
	var email_verified = $("#email_verified").val();
	if(old_email != email || email_verified == 0)
	{
		$.post("check_admin_email_exist",{email:email,userid:userid})
		.done(function( data ) {
		  if(data == 0)
		  {
			 
			  //alert("Email already using another user");
			  $("#email_verify_error").html('<b>This email address already using another user</b>');
		  }
		  else if(data == 1)
		  {
			  $('#modal1-verify1').modal('toggle');
			  $("#email_verify_error").html('');
		  }
	  });
	}
}

function sendverificationcode_phone()
{
	var email = $("#email").val();
	var phone = $("#phone").val();
	var old_phone = $("#old_phone").val();
	var userid = $("#userid").val();
	var phone_verified = $("#phone_verified").val();
	if(old_phone != phone || phone_verified == 0)
	{
		$.post("check_admin_phone_exist",{phone:phone,userid:userid,email:email})
		.done(function( data ) {
		  if(data == 0)
		  {
			
			  //alert("Email already using another user");
			  $("#phone_verify_error").html('<b>This phone no already using another user</b>');
		  }
		  else if(data == 1)
		  {
			  $('#modal2-verify1').modal('toggle');
			 $("#phone_verify_error").html('');
		  }
	  });
	}
}

function reset_sendverificationcode_phone()
{
	var phone = $("#phone").val();
	var old_phone = $("#old_phone").val();
	var userid = $("#userid").val();
	if(old_phone != phone)
	{
		$.post("check_admin_phone_exist",{phone:phone,userid:userid})
		.done(function( data ) {
		  console.log("Success");
	  });
	}
}
function verify_email()
{
	var val1 = $("#modal1_verify1").val();
	var val2 = $("#modal1_verify2").val();
	var val3 = $("#modal1_verify3").val();
	var val4 = $("#modal1_verify4").val();
	var email = $("#email").val();
	var full_val = val1+""+val2+""+val3+""+val4;
	$.post("verify_email",{email:email,code:full_val})
		.done(function(data){
		if(data == 1)
		{
			$("#email_verified").val(1);
			$('#modal1-verify1').modal('hide');  
			check_verified_email_phone();
		}
		else
		{
			alert("Not Verify");
		}			
	});
}

function verify_phone()
{
	var val1 = $("#modal2_verify1").val();
	var val2 = $("#modal2_verify2").val();
	var val3 = $("#modal2_verify3").val();
	var val4 = $("#modal2_verify4").val();
	var phone = $("#phone").val();
	var full_val = val1+""+val2+""+val3+""+val4;
	$.post("verify_phone",{phone:phone,code:full_val})
		.done(function(data){
		if(data == 1)
		{
			$("#phone_verified").val(1);
			$('#modal2-verify1').modal('hide');  
			check_verified_email_phone();
		}
		else
		{
			alert("Not Verify");
		}			
	});
}