<footer id="colophon" class="site-footer relative z-20 bg-white">
  <div class="container-full h-40 lg:h-52 flex flex-col justify-center text-black font-medium">
    <div class="text-xl lg:text-2xl mb-3">
      T : 010-8945-8950<br />
      E : <a href="mailto:mdc_design@naver.com"><span class="text-black/40 hover:underline">mdc_design@naver.com</span></a><br />
    </div>
    <div class="text-lg lg:text-xl">
      Copyright <span class="relative text-2xl lg:text-3xl top-[2px] lg:top-1">©</span> 2022. All rights reserved.
    </div>
  </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Channel Plugin Scripts -->
<script>
  (function() {
    var w = window;
    if (w.ChannelIO) {
      return (window.console.error || window.console.log || function() {})('ChannelIO script included twice.');
    }
    var ch = function() {
      ch.c(arguments);
    };
    ch.q = [];
    ch.c = function(args) {
      ch.q.push(args);
    };
    w.ChannelIO = ch;

    function l() {
      if (w.ChannelIOInitialized) {
        return;
      }
      w.ChannelIOInitialized = true;
      var s = document.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
      s.charset = 'UTF-8';
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
    if (document.readyState === 'complete') {
      l();
    } else if (window.attachEvent) {
      window.attachEvent('onload', l);
    } else {
      window.addEventListener('DOMContentLoaded', l, false);
      window.addEventListener('load', l, false);
    }
  })();
  ChannelIO('boot', {
    "pluginKey": "1d433442-6f73-4a73-839b-87ee3784cbf3"
  });
</script>
<!-- End Channel Plugin -->
</body>

</html>