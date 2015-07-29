<?php
register_nav_menus( array(
	'site_nav' => 'Site navigation',
	'user_nav' => 'User navigation'
) );


// Our sub navigation for pages
function sub_nav($post){ ?>
	<nav class="aside-sub-nav">
	    <ul>
	        <?php 
	        // Sub nav
	        $parent = array_reverse( get_post_ancestors($post->ID));
	        if(array_key_exists(0, $parent)){
	            $first_parent = get_page($parent[0]);
	        }else{
	             $first_parent = $post;
	        }
	        wp_list_pages("title_li=&child_of=".$first_parent->ID); 
	        
	        ?>
	    </ul>
	</nav>
<?php }
