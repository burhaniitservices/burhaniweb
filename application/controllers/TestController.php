<?php
  $to = "someone@domain.com"; // EMAIL OF PERSON TO SEND EMAIL
  $subject = "some subject"; // SUBJECT FOR EMAIL
  $msg = '<img src="image.jpg">'; // BODY OF THE MAIL CAN CONTAIN ALL HTML TAGS AND CSS

// INCLUDE ALL THE HEADERS TO SEND HTML TEMPLET EMAIL
  $headers = "From: something@domail.com\r\n";
  $headers .= "Reply-To: something@domail.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
// HEADERS END HERE

  $mail = mail($to, $subject, $msg, $headers); // USE THE MAIL FUNCTION TO MAIL HTML TEMPLET EMAIL
 ?>
