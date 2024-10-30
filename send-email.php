<?php
include('index.php');

// Get the email ID from POST data
$emailId = $_POST['mail'];

// Correct the subject line concatenation
$subject = "Weather Report for " . $_SESSION['cityName'];


// Include PHPMailer autoloader
require "vendor/autoload.php";

use OpenAI\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$openai = OpenAI::client('enter_openai_api_key_here');  //enter openai api key here

try {
  $cityName = $_SESSION['cityName'];
  $temperature = $weatherData['current']['temp_c'];
  $condition = $weatherData['current']['condition']['text'];
  $windSpeed = $weatherData['current']['wind_mph'];
  $lastUpdated = $weatherData['current']['last_updated'];

  $prompt = "Generate a professional email with the following structure:\n" .
    "1. Subject is added manually don't make it just make body of the email.\n" .
    "2. Don't add anything before greetings\n" .
    "3. Greeting: Address them politely without mentioning name.\n" .
    "4. Weather Summary: Include the current temperature ($temperature °C), weather condition ('$condition'), and wind speed ($windSpeed MPH) for the city of $cityName. Also mention that this information was last updated on $lastUpdated.\n" .
    "5. Closing Statement: Thank the recipient for their attention and wish them a good day and use Aditya for giving best regards at the end.\n" .
    "The tone should be professional and informative.";
  $response = $openai->chat()->create([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
      [
        'role' => 'user',
        'content' => $prompt
      ]
    ],
    'max_tokens' => 100,
  ]);

  // Extract message from response
  $message = $response['choices'][0]['message']['content'];
} catch (OpenAI\Exceptions\ErrorException $e) {
  if ($e->getCode() == 'quota_exceeded') {
    echo "Error: You have exceeded your API quota. Please check your billing details.";
  } else {
    echo "Error generating message: " . htmlspecialchars($e->getMessage());
  }
  exit;
}




$mail = new PHPMailer(true);

try {
  // SMTP configuration
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  // Sender's email and name
  $mail->Username = "adn1203@gmail.com"; // Your Gmail address
  $mail->Password = "jmvz boae vpjx nght"; // Your Gmail App Password

  // Set sender and recipient
  $mail->setFrom($mail->Username, "Aditya");
  $mail->addAddress($emailId); // Recipient's email

  // Email subject and body
  $mail->Subject = $subject;
  $mail->Body = $message;

  // Send the email
  if ($mail->send()) {
    echo '<div id="message" style="padding: 10px; margin-top: 20px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; font-family: Arial, sans-serif;">
            <strong>Success!</strong> The weather report has been sent to ' . htmlspecialchars($emailId) . '.
          </div>';
  } else {
    echo '<div id="message" style="padding: 10px; margin-top: 20px; border-radius: 5px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; font-family: Arial, sans-serif;">
            <strong>Error!</strong> Message could not be sent. Mailer Error: ' . htmlspecialchars($mail->ErrorInfo) . '
          </div>';
  }
} catch (Exception $e) {
  echo '<div id="message" style="padding: 10px; margin-top: 20px; border-radius: 5px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; font-family: Arial, sans-serif;">
          <strong>Error!</strong> Message could not be sent. Mailer Error: ' . htmlspecialchars($mail->ErrorInfo) . '
        </div>';
}
session_unset();
session_destroy();
?>
<script>
  setTimeout(function() {
    document.getElementById("message").style.display = "none";
    window.location.href = "/weather_emailer/";
  }, 5000);
</script>
