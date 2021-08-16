<?php
	// load in mailchimp library
	include('./MailChimp.php');
	
	// namespace defined in MailChimp.php
	use \DrewM\MailChimp\MailChimp;
	
	// connect to mailchimp
	$MailChimp = new MailChimp('e5998b13a557c052a7572a3bdcfa82aa-us19'); // put your API key here
	$list = 'df7a7d0c50'; // put your list ID here
  
	$email = $_GET['EMAIL']; // Get email address from form
  $id = md5(strtolower($email)); // Encrypt the email address
  $message = $_GET['MESSAGE']; //Get message from form
  $message = wordwrap($message, 70, "\r\n");

  mail('ustymchyk.nazar@gmail.com', $email, $message);

  // setup th merge fields
	$mergeFields = array(
    'FNAME'=>$_GET['FNAME'],
    'LNAME'=>$_GET['LNAME'],
    'PHONE'=>$_GET['PHONE'],
    'ADDRESS'=>$_GET['ADDRESS']
  );

	// remove empty merge fields
  $mergeFields = array_filter($mergeFields);
	$result = $MailChimp->put("lists/$list/members/$id", array(
  	'email_address'     => $email,
    'status'            => 'subscribed',
    'merge_fields'      => $mergeFields, 
  	'update_existing'   => true, // YES, update old subscribers!
  ));

	echo json_encode($result);