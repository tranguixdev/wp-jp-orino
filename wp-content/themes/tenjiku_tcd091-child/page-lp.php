<?php
/*
Template Name:LP page
*/
__('LP page', 'tcd-tenjiku');
?>
<?php
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
  
    get_header();
     $options = get_design_plus_option();
     $catch = get_post_meta($post->ID, 'page_header_catch', true);
     $catch_mobile = get_post_meta($post->ID, 'page_header_catch_mobile', true);
     $catch_font_type = get_post_meta($post->ID, 'page_header_catch_font_type', true) ?  get_post_meta($post->ID, 'page_header_catch_font_type', true) : 'type3';
     $headline = get_post_meta($post->ID, 'page_header_headline', true);
     $headline_font_type = get_post_meta($post->ID, 'page_header_headline_font_type', true) ?  get_post_meta($post->ID, 'page_header_headline_font_type', true) : 'type2';
     $desc = get_post_meta($post->ID, 'page_header_desc', true);
     $desc_mobile = get_post_meta($post->ID, 'page_header_desc_mobile', true);
     $bg_image = wp_get_attachment_image_src(get_post_meta($post->ID, 'page_header_bg_image', true), 'full');
     $use_overlay = get_post_meta($post->ID, 'page_header_use_overlay', true);
     $hide_page_header = get_post_meta($post->ID, 'hide_page_header', true);
     $page_hide_bread = get_post_meta($post->ID, 'page_hide_bread', true);
     $page_layout = get_post_meta($post->ID, 'page_layout', true) ?  get_post_meta($post->ID, 'page_layout', true) : 'type1';
     $page_header_height = get_post_meta($post->ID, 'page_header_height', true) ?  get_post_meta($post->ID, 'page_header_height', true) : 'type1';
     $change_content_width = get_post_meta($post->ID, 'change_content_width', true);
     if($change_content_width){
       $page_content_width = get_post_meta($post->ID, 'page_content_width', true) ?  get_post_meta($post->ID, 'page_content_width', true) : '710';
     } else {
       $page_content_width = '710';
     }
     if(!$hide_page_header){
?>
<div id="page_header"<?php if($page_header_height == 'type2'){ echo ' class="full_height"'; }; ?>>

 <?php if($page_header_height == 'type2'){ ?>

 <div id="page_header_inner">
  <?php if($catch){ ?>
  <h1 class="catch animate_item rich_font_<?php echo esc_attr($catch_font_type); ?>"><?php if($catch_mobile){ ?><span class="pc"><?php }; ?><?php echo wp_kses_post(nl2br($catch)); ?><?php if($catch_mobile){ ?></span><span class="mobile"><?php echo wp_kses_post(nl2br($catch_mobile)); ?></span><?php }; ?></h1>
  <?php }; ?>
  <?php if($desc){ ?>
  <p class="desc animate_item"><?php if($desc_mobile){ ?><span class="pc"><?php }; ?><?php echo wp_kses_post(nl2br($desc)); ?><?php if($desc_mobile){ ?></span><span class="mobile"><?php echo wp_kses_post(nl2br($desc_mobile)); ?></span><?php }; ?></p>
  <?php }; ?>
 </div>

 <a class="animate_item" id="page_contents_link" href="<?php if($page_hide_bread){ echo '#main_contents'; } else { echo '#bread_crumb'; }; ?>"></a>

 <?php } else { ?>

 <?php if($desc){ ?>
 <div class="desc_area animate_item">
  <p class="desc"><?php if($desc_mobile){ ?><span class="pc"><?php }; ?><?php echo wp_kses_post(nl2br($desc)); ?><?php if($desc_mobile){ ?></span><span class="mobile"><?php echo wp_kses_post(nl2br($desc_mobile)); ?></span><?php }; ?></p>
 </div>
 <?php }; ?>

 <?php if($headline){ ?>
 <div class="headline_area animate_item">
  <h1 class="headline common_headline rich_font_<?php echo esc_attr($headline_font_type); ?>"><?php echo wp_kses_post(nl2br($headline)); ?></h1>
 </div>
 <?php }; ?>

 <?php }; // END page header height ?>

 <?php if($use_overlay) { ?>
 <div class="overlay"></div>
 <?php }; ?>

 <?php if(!empty($bg_image)) { ?>
  <!-- cw_editor  responsive hero image according to screen height -->
  <!-- <div class="bg_image" style="background:url(<?php echo esc_attr($bg_image[0]); ?>) no-repeat center top; background-size:cover;"></div> -->
  <img class="<?php echo strpos($current_url, 'brand') == false ? 'center-img' : 'cover-img';?>" src="<?php echo esc_attr($bg_image[0]); ?>" >
  <!-- cw_editor END -->
 <?php }; ?>

</div>
<?php }; ?>

<?php if(!$page_hide_bread){ get_template_part('template-parts/breadcrumb'); }; ?>
<div id="main_contents"<?php if($page_layout == 'type2'){ echo ' class="one_column_layout" style="width:' . $page_content_width . 'px;"'; }; ?>>

 <div id="main_col">

  <article id="article">

   <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

   <?php // post content ------------------------------------------------------------------------------------------------------------------------ ?>
   <div class="post_content clearfix">
    <?php
         the_content();
         if ( ! post_password_required() ) {
           custom_wp_link_pages();
         }
    ?>
   </div>

   <?php endwhile; endif; ?>

  </article>

 </div><!-- END #main_col -->
</div><!-- END #main_contents -->
<?php get_footer(); ?>