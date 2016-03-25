<footer>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <p class="text-left">&copy  <script>document.write(new Date().getFullYear())</script> <a href="/">Cornerstone Hosting</a></p>
        </div>
        <div class="small-12 medium-6 columns">
            <p class="text-right">Site by <a href="http://karolbrennan.com">Karol Brennan</a></p>
        </div>
    </div>
</footer>



<script>
    $('nav a').on('click', function() {
        var scrollAnchor = $(this).attr('data-scroll'),
            scrollPoint = $('section[data-anchor="' + scrollAnchor + '"]').offset().top - 48;

        $('body,html').animate({
            scrollTop: scrollPoint
        }, 500);

        return false;
    });

    $(window).scroll(function() {
        var windscroll = $(window).scrollTop();
        if (windscroll >= 100) {
            $('section').each(function(i) {
                if ($(this).position().top <= windscroll + 140) {
                    $('nav a.active').removeClass('active');
                    $('nav a').eq(i).addClass('active');
                }
            });

        } else {
            $('nav a.active').removeClass('active');
            $('nav a:first').addClass('active');
        }
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ){
            if(windscroll >= 50){
                $('header').addClass('scroll');
            } else {
                $('header').removeClass('scroll');
            }
        }
    }).scroll();
</script>

<script src="js/mailer.js"></script>

</body>
</html>