<?PHP
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

// change here
$sender = 'someone@somedomain.tld';
$recipient = 'ponzoniluca@gmail.com';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
  print_r(apache_request_headers());
  echo "\nError: Message not accepted";
}
?>