<?php

$hasError = false;
$sent     = false;

if(isset($_POST['submitform'])) {
  $name    = trim(htmlspecialchars($_POST['name'], ENT_QUOTES));
  $email   = trim($_POST['email']);
  $message = trim(htmlspecialchars($_POST['message'], ENT_QUOTES));

  $fieldsArray = array(
    'name'    => $name,
    'email'   => $email,
    'message' => $message
  );

  $errorArray = array();

  foreach($fieldsArray as $key => $val) {
    switch($key) {
      case 'name':
      case 'message':
        if(empty($val)) {
          $hasError = true;
          $errorArray[$key] = ucfirst($key) . " field wast left empty.";
        }
        break;
      case 'email':
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $hasError = true;
            $errorArray[$key] = "Invalid Email Address Entered";
          } else {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
          }
          break;
    }
  }

  if($hasError !== true) {
    $to          = "the.jinyoung.ko@gmail.com";
    $subject     = "Message from Contact form: $name";
    $msgcontents = "Name: $name<br>Email: $email<br>Message: $message";
    $headers     = "MIME-Version: 1.0 \r\n";
    $headers    .= "Content-type: text/html; charset=iso-8859-1 \r\n";
    $headers    .= "From: $name <$email> \r\n";
    $mailsent    = mail($to, $subject, $msgcontents, $headers);
    if($mailsent) {
      $sent = true;
      unset($name);
      unset($email);
      unset($message);
    }
  }
}

?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="iso-8859-1">
  <title>Contact Form</title>
  <script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
  <script type="text/javascript">
  jQuery(document).ready(function($) {
    $("#contactform").validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
          maxlength: 30
        },
        email: {
          required: true,
          email: true
        },
        message: {
          required: true,
          minlength: 50,
          maxlength: 500
        }
      },
      messages: {
        name: {
          required: "Please enter your name",
          minlength: "Your name seems a bit short doesn't it?",
          maxlength: "Sorry! Your name seems a bit long."
        },
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address"
        },
        message: {
          required: "Please enter your message",
          minlength: "Your message seems a bit short doesn't it? Please enter at least 50 characters.",
          maxlength: "Your message is a bit too long. Please enter no more than 500 characters."
        }
      }
    });
  });
  </script>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Contact Me</h1>
    <form id="contactform" method="post" action="">
      <?php
        if($sent === true) {
          echo "<h2 class='success'>Thanks, your message has been sent successfully</h2>";
        } else if($hasError === true) {
          echo '<ul class="errorlist">';
          foreach($errorArray as $key => $val) {
            echo "<li>" . ucfirst($key) . " field error - $val</li>";
          }
          echo '</ul>';
        }
      ?>
      <input type="text" name="name" value="<?php echo (isset($name) ? $name : ""); ?>" placeholder="Your Name">
      <input type="email" name="email" value="<?php echo (isset($email) ? $email : ""); ?>" placeholder="Your Email">
      <textarea name="message" placeholder="Your message"><?php echo (isset($message) ? $message : ""); ?></textarea>
      <input type="submit" name="submitform" value="Send">
    </form>
  </div>
</body>
</html>
