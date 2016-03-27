<?php include("includes/header.php"); ?>
<section class="signup">
    <div class="row">
        <div class="small-12 columns">
            <h2>Sign Up</h2>
            <p>Please note that we are a small company and handle all hosting signups
                manually to ensure the best in customer service.</p>
            <p>Upon submission of this form, you'll receive an invoice via PayPal.
               Once you complete payment, your account will be set up for you.</p>
            <p>Please allow up to 24 hours to receive your welcome email.</p>
            <div id="signup-form-messages"></div>
            <form id="signup-form" action="scripts/signupmailer.php" method="post">
                <input type="text" name="name" placeholder="name" required>
                <input type="email" name="email" placeholder="@" required>
                <input type="email" name="paypal" placeholder="paypal email" required>
                <input type="text" name="domain" placeholder="domain" required>
                <select name="package" required>
                    <option>Select a package...</option>
                    <option name="foundation">Foundation</option>
                    <option name="cornerstone">Cornerstone</option>
                    <option name="keystone">Keystone</option>
                </select>
                <textarea name="message" placeholder="comments/questions"></textarea>
                <div class="g-recaptcha" data-sitekey="6LdOrRsTAAAAAFSTcKZjU8L8yeyeJQ-aEmB2UfvC"></div>
                <button>Sign Up!</button>
            </form>
            <script src="js/signupmailer.js"></script>
        </div>
    </div>
</section>


<?php include("includes/footer.php"); ?>