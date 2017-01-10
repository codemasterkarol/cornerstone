<?php
    /**
     * Get credentials and keys from the ini file
     */
    $credentials = parse_ini_file('../app.ini');
    $whmusername = $credentials['whmUsername'];
    $whmpassword = $credentials['whmPassword'];
    $whmpromo = $credentials['whmPromo'];
    $reCaptchaKey = $credentials['recaptchaKey'];

    /**
     * Process the form ONLY if it is a post request
     */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields, sanitize and remove whitespace.
        $name = htmlentities(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $domain = htmlentities(trim($_POST['domain']));
        if (preg_match('#^http(s)?://#', $domain)) {
            $domain = preg_replace('#^http(s)?://#', '', $domain);
        }
        if(preg_match('/^www\./', $domain)) {
            $domain = preg_replace('/^www\./', '', $domain);
        }

        $promocode = htmlentities(trim($_POST['promocode']));
        $package = $_POST['package'];
        $password = generatePassword();

        // get the position of the .TLD for use in generating a username
        $periodPosition = strrpos($domain, '.');
        $limit = $periodPosition <= 8 ? $periodPosition : 8;
        $username = substr($domain, 0, $limit);
        // if short username, add digits to reach 8 characters
        if(strlen($periodPosition) < 8){
            for($i = $periodPosition; $i < 8; $i++){
                $username .= rand(0,9);
            }
        }

        // package options to ensure ONLY these are valid
        $packageoptions = ['corner17_Foundation','corner17_Cornerstone','corner17_Keystone'];

        if(!in_array($package, $packageoptions)){
            http_response_code(400);
            echo "Please select a package";
            exit;
        }

        if(isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
        } else {
            http_response_code(400);
            echo "Please check the reCaptcha.";
            exit;
        }

        if($promocode !== $whmpromo){
            http_response_code(400);
            echo "Sorry, your promo code was invalid. Try again.";
            exit;
        }

        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

        $response = file_get_contents($verifyUrl."?secret=".$reCaptchaKey."&response=".$captcha);

        $responseKeys = json_decode($response,true);

        if(intval($responseKeys["success"]) !== 1) {
            echo "Spammer! Get out!";
            exit;
        }

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($domain) OR empty($email) OR empty($promocode) OR $responseKeys === null) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "No can do buddy. Go try again! Make sure everything is filled out!";
            exit;
        }

        $query = "https://cornerstone.host:2087/json-api/createacct?api.version=1&domain=" .
                  $domain."&username=".$username."&contactemail=".$email."&plan=".$package."&password=".$password;

        $curl = curl_init();                                // Create Curl Object
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);       // Allow self-signed certs
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);       // Allow certs that do not match the hostname
        curl_setopt($curl, CURLOPT_HEADER,0);               // Do not include header in output
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);       // Return contents of transfer on curl_exec
        $header[0] = "Authorization: Basic " . base64_encode($whmusername.":".$whmpassword) . "\n\r";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);    // set the username and password
        curl_setopt($curl, CURLOPT_URL, $query);            // execute the query
        $result = curl_exec($curl);
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
            // log error if curl exec fails
        }
        curl_close($curl);

        $result = json_decode($result);

        if($result->metadata->result !== 1){
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Sorry there was an error with your request, please try again!";
            exit;
        }

        // Set the email subject.
        $subject = "Welcome to Cornerstone.";

        // Build the email content.
        $email_content = "Welcome to Cornerstone, {$name}!\n\n";
        $email_content .= "Your sign up was successful! Here are your next steps and your account details are below.\n\n";
        $email_content .= "Go to your domain registrar and set your nameservers to:\n";
        $email_content .= "ns1.cornerstone.host\nns2.cornerstone.host\n";
        $email_content .= "\n\n";
        $email_content .= "Domain: <a href='http://{$domain}'>{$domain}</a>\n";
        $email_content .= "Cpanel: <a href='http://{$domain}/cpanel'>{$domain}/cpanel</a>\n";
        $email_content .= "Username: {$username}\n";
        $email_content .= "Password: {$password}\n";

        // Build the email headers.
        $email_headers = "From: Cornerstone Hosting <$email>";
        $email_headers .= "MIME-Version: 1.0\r\n";
        $email_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Send the email.
        if (mail($email, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your sign up was successful!!";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Uh oh. Something went wrong!";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "THOU SHALT NOT EMAIL!";
    }


    function generatePassword () {
        $pass = '';
        $possibleCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-';
        $limit = strlen($possibleCharacters);
        for ($i = 0; $i <= 12; $i++) {
            $pass .= $possibleCharacters[rand(0, $limit)];
        }
        return $pass;
    }