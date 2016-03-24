<section id="contact-section" data-anchor="contact"><a id="contact"></a>
    <div class="row">
        <div class="small-12 columns">
            <h2>Contact</h2>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <div id="form-messages"></div>
            <form id="contact-form" action="scripts/mailer.php" method="post">
                <input type="text" id="name" placeholder="name" required>
                <input type="email" id="email" placeholder="@" required>
                <textarea placeholder="message" id="message" required></textarea>
                <button>Send!</button>
            </form>
        </div>
    </div>
</section>