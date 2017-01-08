<section id="signup-section" data-anchor="signup"><a id="signup"></a>
    <div class="row">
        <div class="small-12 columns">
            <h2>Sign Up</h2>
            <p>Note: We are currently in a closed beta - you will need a specific promo code in order to sign up. Without it your sign up will be rejected. If you are interested in joining our beta testing time please <a href="#contact">contact us</a> below!</p>
            <div id="signup-form-messages"></div>
            <form id="signup-form" action="scripts/signup.php" method="post">
                <input type="text" name="name" placeholder="name" required>
                <input type="email" name="email" placeholder="@" required>
                <input type="text" name="domain" placeholder="domain" required>
                <input type="text" name="promocode" placeholder="promo code" required>
                <select name="package" required>
                    <option>Select a package...</option>
                    <option value="corner17_Foundation">Foundation</option>
                    <option value="corner17_Cornerstone">Cornerstone</option>
                    <option value="corner17_Keystone">Keystone</option>
                </select>
                <div class="g-recaptcha" id="recaptcha2"></div>
                <button>Sign Up!</button>
            </form>
            <script src="js/signupmailer.js"></script>
        </div>
    </div>
</section>
<div class="arrow-down signup"></div>