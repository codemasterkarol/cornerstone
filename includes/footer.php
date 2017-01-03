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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89776307-1', 'auto');
  ga('send', 'pageview');

</script>

<script>
    $('nav a').on('click', function() {
        var scrollAnchor = $(this).attr('data-scroll'),
            scrollPoint = $('section[data-anchor="' + scrollAnchor + '"]').offset().top - 48;

        $('body,html').animate({
            scrollTop: scrollPoint
        }, 500);

        return false;
    });


    $('#menutoggle').on('click', function(e){
        e.preventDefault();
        $('nav').toggleClass('show');
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

<script src="/js/mailer.js"></script>

</body>
</html>
