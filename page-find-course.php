<?php /* Template Name: Find undervisning */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<header class="page-header">
  <div class="center">
    <h1 class="page-title"><?php the_title(); ?></h1>
  </div>
</header>

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
    <p class="section__manchet">Alle kategorier</p>
    <?php
    $categories = get_categories();
    foreach($categories as $category) { ?>
    <a href="<?php echo get_category_link( $category->term_id ) ?>" title="Se alle opslag under <?php echo $category->name ?>"><?php echo $category->name ?></a><span class="category-list-divider">|</span>
    <?php }  ?>
  </div>
</section>

<section class="tag-list-container">
  <div class="center">
    <h2 class="section__title">Tags</h2>
    <p class="section__manchet">Her kan du finde mere specifikke nøgleord, fx "begynder" eller "PHP".</p>
    <div class="live-search-container">
      <label for="live-search">Find tag:</label><input type="search" class="js-live-search" placeholder="Hvad leder du efter" />
    </div>
    <?php $tags = get_tags(); ?> 
    <?php
    foreach($tags as $tag) { ?>
      <a href="<?php echo get_tag_link( $tag->term_id ) ?>" title="Se alle opslag under <?php echo $tag->name ?>" class="tag-list-item js-live-search-item"><?php echo $tag->name ?></a>
    <?php }  ?>
  </div>
</section>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>