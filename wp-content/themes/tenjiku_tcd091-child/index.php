<?php
     get_header();
     $options = get_design_plus_option();
     $headline = $options['archive_blog_header_headline'];
     $headline_font_type = $options['blog_headline_font_type'];
     $desc = $options['archive_blog_header_desc'];
     $desc_mobile = $options['archive_blog_header_desc_mobile'];
     $bg_image = wp_get_attachment_image_src($options['archive_blog_header_bg_image'], 'full');
     $use_overlay = $options['archive_blog_header_use_overlay'];
     // overwrite the data if category data exist
     if (is_category()) {
       $query_obj = get_queried_object();
       $headline = $query_obj->name;
       if (!empty($query_obj->description)){
         $desc = $query_obj->description;
       }
       $current_cat_id = $query_obj->term_id;
       $term_meta = get_option( 'taxonomy_' . $current_cat_id, array() );
       if (!empty($term_meta['image'])){
         $bg_image = wp_get_attachment_image_src( $term_meta['image'], 'full' );
       }
       if (!empty($term_meta['image']) && !empty($term_meta['use_overlay'])){
         $use_overlay = $term_meta['use_overlay'];
       }
       if (!empty($term_meta['desc_mobile'])){
         $desc_mobile = $term_meta['desc_mobile'];
       }
     } elseif(is_tag()) {
       $query_obj = get_queried_object();
       $headline = $query_obj->name;
       if (!empty($query_obj->description)){
         $desc = $query_obj->description;
       }
     } elseif ( is_day() ) {
       $headline = sprintf( __( 'Archive for %s', 'tcd-tenjiku' ), get_the_time( __( 'F jS, Y', 'tcd-tenjiku' ) ) );
     } elseif ( is_month() ) {
       $headline = sprintf( __( 'Archive for %s', 'tcd-tenjiku' ), get_the_time( __( 'F, Y', 'tcd-tenjiku') ) );
     } elseif ( is_year() ) {
       $headline = sprintf( __( 'Archive for %s', 'tcd-tenjiku' ), get_the_time( __( 'Y', 'tcd-tenjiku') ) );
     } elseif(is_author()) {
       $author_info = $wp_query->get_queried_object();
       $author_id = $author_info->ID;
       $user_data = get_userdata($author_id);
       $user_name = $user_data->display_name;
       $headline = sprintf( __( 'Archive for %s', 'tcd-tenjiku' ), $user_name );
     }

?>
<div id="page_header"<?php if ( is_day() || is_month() || is_year() || is_author() ) { echo ' class="small"'; }; ?>>

 <?php if ( is_day() || is_month() || is_year() || is_author() ) { } else { ?>
 <?php if($desc){ ?>
 <div class="desc_area animate_item">
  <p class="desc"><?php if($desc_mobile){ ?><span class="pc"><?php }; ?><?php echo wp_kses_post(nl2br($desc)); ?><?php if($desc_mobile){ ?></span><span class="mobile"><?php echo wp_kses_post(nl2br($desc_mobile)); ?></span><?php }; ?></p>
 </div>
 <?php }; ?>
 <?php }; ?>

 <?php if($headline){ ?>
 <div class="headline_area animate_item">
  <h1 class="headline common_headline rich_font_<?php echo esc_attr($headline_font_type); ?>"><?php echo wp_kses_post(nl2br($headline)); ?></h1>
 </div>
 <?php }; ?>

 <?php if($use_overlay) { ?>
 <div class="overlay"></div>
 <?php }; ?>

 <?php if(!empty($bg_image)) { ?>
 <div class="bg_image" style="background:url(<?php echo esc_attr($bg_image[0]); ?>) no-repeat center top; background-size:cover;"></div>
 <?php }; ?>

</div>

<div id="main_contents">


 <?php
      // widget ------------------------
      get_sidebar();
 ?>

</div><!-- END #main_contents -->
<?php get_footer(); ?>