<?php




// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if(isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    } else {
        http_response_code(400);
        echo "Please check the reCaptcha.";
        exit;
    }

    $secretKey = "6LdOrRsTAAAAAA6zaSfSPiIGiXrzkakuEoG8DOHq";
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

    $response=file_get_contents($verifyUrl."?secret=".$secretKey."&response=".$captcha);

    $responseKeys = json_decode($response,true);

    if(intval($responseKeys["success"]) !== 1) {
       echo "<img src='../img/spam.jpeg' alt='Spammer! GTFO!'>";
    } else {
        echo '<h2>Thanks for posting comment.</h2>';
    }


    // Check that data was sent to the mailer.
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Something is wrong with the data. It's not matching.";
        exit;
    }

    // Set the recipient email address.
    $recipient = "codemasterkarol@gmail.com";

    // Set the email subject.
    $subject = "Cornerstone: New contact from $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Ah shit it couldn't send the email.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "FORBIDDEN!";
}

?>
