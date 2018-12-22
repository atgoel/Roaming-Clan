<?php
  global $post;
  $schema_on = '';
  $schema_link = '';
  $schema_prop_url = '';
  $schema_prop_title = '';

  $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = ' &raquo; '; // delimiter between crumbs
  $home = __('Home','mesocolumn'); // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
  $schema_on = get_theme_option('schema_on');

  if($schema_on == 'Enable') {
  $schema_link = 'http://data-vocabulary.org/Breadcrumb';
  $schema_prop_url = 'url';
  $schema_prop_title = 'title';
  }

  $homeLink = home_url();

  if ( is_home() || is_front_page()) {

  if ($showOnHome == 1) {

    echo '<div id="breadcrumbs"><div class="innerwrap">';
    echo __('You are here: ', 'mesocolumn');
    echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $homeLink . '">' . '<span itemprop="'.$schema_prop_title.'">' . $home . '</span>' . '</a></span>';
    echo '</div></div>';

      }

  } else {

    echo '<div id="breadcrumbs"><div class="innerwrap">';

    if( !is_single() ) { echo __('You are here: ', 'mesocolumn'); }

    echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $homeLink . '">' . '<span itemprop="'.$schema_prop_title.'">' . $home . '</span>' . '</a></span>' . $delimiter . ' ';


    if ( is_category() ) {


      $thisCat = get_category(get_query_var('cat'), false);

      if ($thisCat->parent != 0) {

      $category_link = get_category_link( $thisCat->parent );

       echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $category_link . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_cat_name( $thisCat->parent ) . '</span>' . '</a></span>' . $delimiter . ' ';

     }

      $category_id = get_cat_ID( single_cat_title('', false) );
      $category_link = get_category_link( $category_id );


      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $category_link . '">' . '<span itemprop="'.$schema_prop_title.'">' . single_cat_title('', false) . '</span>' . '</a></span>';


    } elseif ( is_search() ) {

      echo __('Search results for', 'mesocolumn') . ' "' . get_search_query() . '"';

    } elseif ( is_day() ) {

      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_year_link(get_the_time('Y')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';

     echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('F') . '</span>' . '</a></span>' . $delimiter . ' ';


    echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_day_link(get_the_time('Y'),get_the_time('m'),get_the_time('d')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('d') . '</span>' . '</a></span>';


    } elseif ( is_month() ) {

      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_year_link(get_the_time('Y')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';

      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('F') . '</span>' . '</a></span>';


    } elseif ( is_year() ) {


      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_year_link(get_the_time('Y')) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_time('Y') . '</span>' . '</a></span>';


    } elseif ( is_single() && !is_attachment() ) {

      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;

       echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $homeLink . '/' . $slug['slug'] . '">' . '<span itemprop="'.$schema_prop_title.'">' . $post_type->labels->singular_name . '</span>' . '</a></span>';


// get post type by post
$post_type = $post->post_type;
// get post type taxonomies
$taxonomies = get_object_taxonomies( $post_type, 'objects' );
if($taxonomies) {
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
// get the terms related to post
$terms = get_the_terms( $post->ID, $taxonomy_slug );
if ( !empty( $terms ) ) {
foreach ( $terms as $term ) {
$taxlist .= ' '. $delimiter . ' ' . '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_term_link( $term->slug, $taxonomy_slug ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . ucfirst($term->name) . '</span>' . '</a></span>';
}
}
}
if($taxlist) { echo $taxlist; }
}
      echo ' '. $delimiter . ' ' . get_the_title();

      } else {

      $category = get_the_category();
      if ($category) {

      foreach ($category as $cat ) {

        echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_category_link( $cat->term_id ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . $cat->name  . '</span>' . '</a></span>' . $delimiter . ' ';

 }
      }

      echo get_the_title();
      }


    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {

      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {

      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');

      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink($parent) . '">' . '<span itemprop="'.$schema_prop_title.'">' . $parent->post_title  . '</span>' . '</a></span>';

      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {

    if( class_exists('buddypress') ) {
    global $bp;

    if( bp_is_groups_component() ){
     echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . home_url() . '/' . bp_get_root_slug( 'groups' ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_get_root_slug( 'groups' ) . '</span>' . '</a></span>';

    if( !bp_is_directory()) {
     echo $delimiter.'<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . home_url() . '/' . bp_get_root_slug( 'groups' ) . '/'.  bp_current_item() . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_current_item() . '</span>' . '</a></span>';
if( bp_current_action() ) {
    echo $delimiter.'<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . home_url() . '/' . bp_get_root_slug( 'groups' ) . '/'.  bp_current_item() . '/' . bp_current_action() . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_current_action() . '</span>' . '</a></span>';
}
             }

} else if( bp_is_members_directory() ){

     echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . home_url() . '/' . bp_get_root_slug( 'members' ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_get_root_slug( 'members' ) . '</span>' . '</a></span>';


} else if( bp_is_user() ){

     echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . home_url() . '/' . bp_get_root_slug( 'members' ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_get_root_slug( 'members' ) . '</span>' . '</a></span>';


     echo $delimiter.'<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . bp_core_get_user_domain( $bp->displayed_user->id )  . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_get_displayed_user_username() . '</span>' . '</a></span>';


  if( bp_current_action() ) {
    echo $delimiter.'<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . bp_core_get_user_domain( $bp->displayed_user->id ) . bp_current_component() . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_current_component() . '</span>' . '</a></span>';
}


} else {

     if( bp_is_directory()) {
    echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink() . '">' . '<span itemprop="'.$schema_prop_title.'">' . bp_current_component() . '</span>' . '</a></span>';
          } else {
       echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink() . '">' . '<span itemprop="'.$schema_prop_title.'">' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
          }
}


 }  else {

  echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink() . '">' . '<span itemprop="'.$schema_prop_title.'">' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
 }


    } elseif ( is_page() && $post->post_parent ) {

      $parent_id  = $post->post_parent;
      $breadcrumbs = array();

      while ($parent_id) {

      $page = get_page($parent_id);

        $breadcrumbs[] = '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink($page->ID) . '">' . '<span itemprop="'.$schema_prop_title.'">' . get_the_title($page->ID)  . '</span>' . '</a></span>';

        $parent_id  = $page->post_parent;
      }

      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';

      }


      echo $delimiter . '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_permalink() . '">' . '<span itemprop="'.$schema_prop_title.'">' . the_title_attribute('echo=0') . '</span>' . '</a></span>';

    } elseif ( is_tag() ) {

      $tag_id = get_term_by('name', single_cat_title('', false), 'post_tag');
      if($tag_id) { $tag_link = get_tag_link( $tag_id->term_id ); }

      echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . $tag_link . '">' . '<span itemprop="'.$schema_prop_title.'">' . single_cat_title('', false) . '</span>' . '</a></span>';


    } elseif ( is_author() ) {

       global $author;
      $userdata = get_userdata($author);

     echo '<span itemscope itemtype="'. $schema_link . '"><a itemprop="'.$schema_prop_url.'" href="' . get_author_posts_url( $userdata->ID ) . '">' . '<span itemprop="'.$schema_prop_title.'">' . $userdata->display_name  . '</span>' . '</a></span>';


    } elseif ( is_404() ) {

      echo ' '. $delimiter . ' ' . __('Error 404', 'mesocolumn');

    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo ' '. $delimiter . ' ' . __('Page', 'mesocolumn') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div></div>';

  }


?>