<?php get_header(); ?>
 <section class="banner-container" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/banner-frontpage.jpg)">
      <div class="banner__content">
        <h2 class="banner__title">Find en underviser til det <br/> du gerne vil lære i dag</h2>
        <a href="#how-it-works" class="btn banner-cta">Se hvordan det virker</a>
      </div>
    </section>
    <section class="posts-search">
      <form role="search" method="get" class="center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="visuallyhidden" for="s">Hvad vil du lære?</label>
        <input placeholder="Hvad vil du lære?" type="search" class="inline-element" id="s" name="s">
        <label for="sted">
            <select name="sted" id="location_name" class="inline-element area-picker">
              <option value="">Hele landet</option>
              <?php  $locations = get_terms_by_post_type('sted','','post','all');
                foreach ( $locations as $location ){ ?>
                  <option value="<?php echo $location->slug; ?>"><?php echo $location->name;  ?></option>
                <?php }
              ?>
            </select>
          </label>
        <input type="submit" value="Søg" id="s" class="cta btn inline-element">
      </form>
    </section>
    <section class="popular-categories-container">
      <div class="center">
        <h2 class="section__title">Populære Kategorier</h2>
        <div class="grid-group popular-categories">
          <a href="kategori/it-teknologi" title="" class="grid size-3 size-6--lap size-12--palm">
            <div class="square popular-category-item">
              <h1 class="popular-category-item__title">IT & Teknologi</h1>
              <img src="<?php echo get_template_directory_uri(); ?>/img/cat-it-teknologi.jpg" alt="Opslag i kategorien IT og teknologi" />
            </div>
          </a>
          <a href="kategori/musik" title="" class="grid size-3 size-6--lap size-12--palm">
            <div class="square popular-category-item">
              <h1 class="popular-category-item__title">Musik</h1>
              <img src="<?php echo get_template_directory_uri(); ?>/img/cat-musik.jpg" alt="Opslag i musik" />
            </div>
          </a>
          <a href="kategori/sport" title="" class="grid size-3 size-6--lap size-12--palm">
            <div class="square popular-category-item">
              <h1 class="popular-category-item__title">Sport</h1>
              <img src="<?php echo get_template_directory_uri(); ?>/img/cat-sport.jpg" alt="Opslag i kategorien sport" />
            </div>
          </a>
          <a href="kategori/sprog" title="" class="grid size-3 size-6--lap size-12--palm">
            <div class="square popular-category-item">
              <h1 class="popular-category-item__title">Sprog</h1>
              <img src="<?php echo get_template_directory_uri(); ?>/img/cat-sprog.jpg" alt="Opslag i sprog" />
            </div>
          </a>
        </div>
        <a href="/find-undervisning" class="btn btn--section" title="Se alle kategorier">Find undervisning</a>
      </div>
    </section>
    <?php get_template_part('partials/how-it-works' ); ?>
<?php get_footer(); ?>