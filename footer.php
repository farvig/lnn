	<footer class="site-footer">
      <div class="social">
        <div class="center">
          Mød os på <a href="https://facebook.com/laernogetnyt" title="Mød os på facebook" target="_blank"><span class="icon-facebook"></span></a>
        </div>
      </div>
      <div class="center">
        <div class="grid-group">
          <article class="grid size-3 size-6--lap size-12--palm">
            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
          </article>
          <article class="grid size-3 size-6--lap size-12--palm">
            <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
          </article>
          <article class="grid size-3 size-6--lap size-12--palm">
            <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
          </article>
          <article class="grid size-3 size-6--lap size-12--palm">
            <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
          </article>
        </div>        
      </div>
      <section class="footer-contact-info">
        <p>Laernogetnyt.dk &copy; 2015 · <a href="/privatpolitik" title="Læs vores Privatpolitik">Privatpolitik</a> · <a href="/betingelser" title="Læs vores betingelser">Betingelser</a> · <a href="/om-laer-noget-nyt/kontakt" title="kontakt os">Kontakt</a>
      </section>
    </footer>
	<?php ivp_display_cookiebox(); ?>
	<?php wp_footer(); ?>
	</body>
</html>