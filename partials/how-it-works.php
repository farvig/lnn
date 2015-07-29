<section id="how-it-works" class="how-it-works-container cta-color-band">
  <div class="center">
    <h2 class="cta-color-band__title">Sådan virker det</h2>
    <div class="grid-group">
      <div class="grid size-4 size-12--palm cta-color-band-item">
        <h1 class="cta-color-band-item__title">Find undervisning</h1>
        <img src="<?php echo get_template_directory_uri(); ?>/img/how-it-works-1.jpg" alt="Find undervisning" class="cta-color-band-item__image">
        <p class="cta-color-band-item__text">Find det der interesserer dig</p>
      </div>
      <div class="grid size-4 size-12--palm cta-color-band-item">
        <h1 class="cta-color-band-item__title">Kontakt underviseren</h1>
        <img src="<?php echo get_template_directory_uri(); ?>/img/how-it-works-2.jpg" alt="Find undervisning" class="cta-color-band-item__image">
        <p class="cta-color-band-item__text">Kontakt underviseren direkte</p>
      </div>
      <div class="grid size-4 size-12--palm cta-color-band-item">
        <h1 class="cta-color-band-item__title">Lær noget nyt</h1>
        <img src="<?php echo get_template_directory_uri(); ?>/img/how-it-works-3.jpg" alt="Find undervisning" class="cta-color-band-item__image">
        <p class="cta-color-band-item__text">Aftal direkte med underviseren</p>
      </div>
    </div>
    <a href="/find-underviser" class="btn btn--section" title="Find en underviser">Find opslag</a>
    <?php if( !is_user_logged_in() ){ ?>
      <a href="/opret-profil" class="btn btn--section" title="Opret en gratis profil">Bliv underviser</a>
    <?php } ?>
  </div>
</section>