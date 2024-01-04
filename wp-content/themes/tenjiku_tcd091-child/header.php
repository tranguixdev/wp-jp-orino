<?php $options = get_design_plus_option(); ?>
<!DOCTYPE html>
<html class="pc" <?php language_attributes(); ?>>
<?php if($options['use_ogp']) { ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<?php } else { ?>
<head>
<?php }; ?>
<meta charset="<?php bloginfo('charset'); ?>">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<meta name="viewport" content="width=device-width">
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="description" content="<?php seo_description(); ?>">
<?php if(is_attachment() && (get_option( 'blog_public' ) != 0)) { ?>
<meta name='robots' content='noindex, nofollow' />
<?php }; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_enqueue_style('style', get_stylesheet_uri(), false, version_num(), 'all'); wp_enqueue_script( 'jquery' ); if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body id="body" <?php body_class(); ?>>

<?php
     // ロードアイコン --------------------------------------------------------------------
     if ( ($options['show_load_screen'] == 'type2' && !isset($_COOKIE['first_visit'])) || ($options['show_load_screen'] == 'type3') || (is_front_page() && $options['show_load_screen'] == 'type2' && $options['load_screen_type2_show_index'])) {
       load_icon();
     };
?>

<?php
     // メッセージ --------------------------------------------------------------------
     if($options['show_header_message'] && $options['header_message']) {
       if( (is_front_page() && $options['show_header_message_top']) || (!is_front_page() && $options['show_header_message_sub']) ) {
?>
<div id="header_message" class="<?php echo esc_attr($options['header_message_width']); ?> show_close_button" <?php if(isset($_COOKIE['close_header_message'])) { echo 'style="display:none;"'; }; ?>>
 <div class="post_content clearfix">
  <?php echo apply_filters('the_content', $options['header_message'] ); ?>
 </div>
 <div id="close_header_message"></div>
</div>
<?php }; }; ?>

<?php
     // ヘッダー ----------------------------------------------------------------------
     if( is_page() && get_post_meta($post->ID, 'hide_page_header_bar', true) ) { } else {
?>
<header id="header" class="page_header_animate_item">
 <div id="header_logo">
  <?php header_logo(); ?>
 </div>
 <a id="drawer_menu_button" href="#"><span></span><span></span><span></span></a>
 <div id="header_circle"></div>
</header>
<?php }; ?>

<div id="container" <?php if( $options['show_load_screen'] == 'type1' ){ echo 'class="no_loading_screen"'; }; ?>>

 <?php
      //  トップページ -------------------------------------------------------------------------
      if(is_front_page()) {

        $index_slider = '';
        $display_header_content = '';

        if(is_mobile() && ($options['mobile_show_index_slider'] == 'type2')){
          $device = 'mobile_';
        } else {
          $device = '';
        }

        if(!is_mobile() && $options['show_index_slider']) {
          $index_slider = $options['index_slider'];
          $display_header_content = 'show';
          $stop_animation = $options['stop_index_slider_animation'];
        } elseif(is_mobile() && ($options['mobile_show_index_slider'] == 'type2') ) {
          $index_slider = $options['mobile_index_slider'];
          $display_header_content = 'show';
          $stop_animation = $options['mobile_stop_index_slider_animation'];
        } elseif(is_mobile() && ($options['mobile_show_index_slider'] == 'type1') ) {
          $index_slider = $options['index_slider'];
          $stop_animation = $options['stop_index_slider_animation'];
          $display_header_content = 'show';
        }

        //  ヘッダーコンテンツ -------------------------------------------------------------------------
        if($display_header_content == 'show'){
 ?>
 <div id="header_slider_wrap">
  <div id="header_slider">

   <?php
        // 固定コンテンツ --------------------------------
        if($options[$device.'show_index_fixed_content']){
   ?>
   <div id="index_fixed_content">
    <div class="caption">

     <?php
          if($options[$device.'index_fixed_content_content_type'] == 'type1') {
            $center_logo_image = wp_get_attachment_image_src( $options[$device.'index_fixed_content_center_logo_image'], 'full' );
            $center_logo_image_width = $options[$device.'index_fixed_content_center_logo_image_width'];
            if(is_mobile() && ($options['mobile_show_index_slider'] == 'type2') ) {
              $center_logo_image_mobile = '';
              $center_logo_image_width_mobile = '';
            } else {
              $center_logo_image_mobile = wp_get_attachment_image_src( $options[$device.'index_fixed_content_center_logo_image_mobile'], 'full' );
              $center_logo_image_width_mobile = $options[$device.'index_fixed_content_center_logo_image_width_mobile'];
            }
     ?>
     <h2 class="<?php if(!$stop_animation){ echo 'animate_item'; }; ?> center_logo">
      <img <?php if($center_logo_image_mobile) { echo 'class="pc"'; }; ?> src="<?php echo esc_attr($center_logo_image[0]); ?>" alt="" title="" <?php if($center_logo_image_width){ ?>style="width:<?php echo esc_attr($center_logo_image_width); ?>px; height:auto;"<?php }; ?> />
      <?php if($center_logo_image_mobile) { ?>
      <img class="mobile" src="<?php echo esc_attr($center_logo_image_mobile[0]); ?>" alt="" title="" <?php if($center_logo_image_width_mobile){ ?>style="width:<?php echo esc_attr($center_logo_image_width_mobile); ?>px; height:auto;"<?php }; ?> />
      <?php }; ?>
     </h2>
     <?php }; ?>

     <?php
          if($options[$device.'index_fixed_content_content_type'] == 'type2'){
            if(is_mobile() && ($options['mobile_show_index_slider'] == 'type2') ) {
              $desc_mobile = '';
            } else {
              $desc_mobile = $options[$device.'index_fixed_content_desc_mobile'];
            }
     ?>

     <?php if($options[$device.'index_fixed_content_catch']){ ?>
     <h3 class="<?php if(!$stop_animation){ echo 'animate_item'; }; ?> catch rich_font_<?php echo esc_attr($options[$device.'index_fixed_content_catch_font_type']); ?>"><?php echo wp_kses_post(nl2br($options[$device.'index_fixed_content_catch'])); ?></h3>
     <?php }; ?>

     <?php if($options[$device.'index_fixed_content_desc']){ ?>
     <div class="<?php if(!$stop_animation){ echo 'animate_item'; }; ?> desc <?php if(!$options[$device.'index_fixed_content_desc_mobile']) { echo 'hide_desc_mobile'; } else { echo 'animate_item_mobile'; }; ?>">
      <p<?php if($desc_mobile && $options[$device.'index_fixed_content_show_desc_mobile']){ echo ' class="pc"'; }; ?>><?php echo wp_kses_post(nl2br($options[$device.'index_fixed_content_desc'])); ?></p>
      <?php if($desc_mobile && $options[$device.'index_fixed_content_show_desc_mobile']) { ?><p class="mobile"><?php echo wp_kses_post(nl2br($desc_mobile)); ?></p><?php }; ?>
     </div>
     <?php }; ?>

     <?php if($options[$device.'index_fixed_content_show_button']){ ?>
     <a class="<?php if(!$stop_animation){ echo 'animate_item'; }; ?> button animation_<?php echo esc_attr($options[$device.'index_fixed_content_button_animation_type']); ?> shape_<?php echo esc_attr($options[$device.'index_fixed_content_button_shape']); ?>" href="<?php echo esc_attr($options[$device.'index_fixed_content_button_url']); ?>" <?php if($options[$device.'index_fixed_content_button_target']){ echo 'target="_blank"'; }; ?>><span><?php echo esc_html($options[$device.'index_fixed_content_button_label']); ?></span></a>
     <?php }; ?>

     <?php }; ?>

    </div><!-- END .caption -->
   </div><!-- END #index_fixed_content -->
   <?php }; // END show_index_fixed_content ?>

   <?php
        // スライダーのアイテム --------------------------------
        $i = 1;
        $slider_item_total = count($index_slider);
        foreach ( $index_slider as $key => $value ) :
          $item_type = $value['slider_type'];
          $slider_content_type = $value['slider_content_type'];
          $image = wp_get_attachment_image_src( $value['image'], 'full');
          $center_logo_image = wp_get_attachment_image_src( $value['center_logo_image'], 'full' );
          $center_logo_image_width = $value['center_logo_image_width'];
          if(is_mobile() && ($options['mobile_show_index_slider'] == 'type2') ) {
            $image_mobile = '';
            $desc_mobile = '';
            $center_logo_image_mobile = '';
            $center_logo_image_width_mobile = '';
          } else {
            $image_mobile = wp_get_attachment_image_src( $value['image_mobile'], 'full');
            $desc_mobile = $value['desc_mobile'];
            $center_logo_image_mobile = wp_get_attachment_image_src( $value['center_logo_image_mobile'], 'full' );
            $center_logo_image_width_mobile = $value['center_logo_image_width_mobile'];
          }
          $video = $value['video'];
          $youtube_url = $value['youtube'];
   ?>
   <div class="item <?php if( ($item_type == 'type2') && $video && auto_play_movie() ) { echo 'video'; } elseif( ($item_type == 'type3') && $youtube_url && auto_play_movie() ) { echo 'youtube'; } else { echo 'image_item'; }; ?> item<?php echo $i; ?> <?php if($i == 1){ echo 'first_item'; }; ?> slick-slide">

    <?php if( (($item_type == 'type2') && $video && auto_play_movie()) || (($item_type == 'type3') && $youtube_url && auto_play_movie()) ) { ?>
    <div class="item_inner">
    <?php }; ?>

    <?php if(!$options[$device.'show_index_fixed_content']){ ?>

    <div class="caption">

     <?php if(($slider_content_type == 'type1') && $center_logo_image) { ?>
     <h2 class="<?php if(!$stop_animation){ ?>animate_item <?php if($i == 1){ echo 'first_animate_item'; }; ?><?php }; ?> center_logo">
      <img <?php if($center_logo_image_mobile) { echo 'class="pc"'; }; ?> src="<?php echo esc_attr($center_logo_image[0]); ?>" alt="" title="" <?php if($center_logo_image_width){ ?>style="width:<?php echo esc_attr($center_logo_image_width); ?>px; height:auto;"<?php }; ?> />
      <?php if($center_logo_image_mobile) { ?>
      <img class="mobile" src="<?php echo esc_attr($center_logo_image_mobile[0]); ?>" alt="" title="" <?php if($center_logo_image_width_mobile){ ?>style="width:<?php echo esc_attr($center_logo_image_width_mobile); ?>px; height:auto;"<?php }; ?> />
      <?php }; ?>
     </h2>
     <?php }; ?>

     <?php if($slider_content_type == 'type2'){ ?>

     <?php if(!empty($value['catch'])){ ?>
     <h3 class="<?php if(!$stop_animation){ ?>animate_item <?php if($i == 1){ echo 'first_animate_item'; }; ?><?php }; ?> catch rich_font_<?php echo esc_attr($value['catch_font_type']); ?>"><?php echo wp_kses_post(nl2br($value['catch'])); ?></h3>
     <?php }; ?>

     <?php if(!empty($value['desc'])){ ?>
     <div class="<?php if(!$stop_animation){ ?>animate_item <?php if($i == 1){ echo 'first_animate_item'; }; ?><?php }; ?> desc <?php if(!$value['show_desc_mobile']) { echo 'hide_desc_mobile'; } else { echo 'animate_item_mobile'; }; ?>">
      <p<?php if($desc_mobile && $value['show_desc_mobile']){ echo ' class="pc"'; }; ?>><?php echo wp_kses_post(nl2br($value['desc'])); ?></p>
      <?php if($desc_mobile && $value['show_desc_mobile']) { ?><p class="mobile"><?php echo wp_kses_post(nl2br($desc_mobile)); ?></p><?php }; ?>
     </div>
     <?php }; ?>

     <?php if($value['show_button']){ ?>
     <a class="<?php if(!$stop_animation){ ?>animate_item <?php if($i == 1){ echo 'first_animate_item'; }; ?><?php }; ?> button animation_<?php echo esc_attr($value['button_animation_type']); ?> shape_<?php echo esc_attr($value['button_shape']); ?>" href="<?php echo esc_attr($value['button_url']); ?>" <?php if($value['button_target']){ echo 'target="_blank"'; }; ?>><span><?php echo esc_html($value['button_label']); ?></span></a>
     <?php }; ?>

     <?php }; ?>

    </div><!-- END .caption -->

    <?php }; // END show_index_fixed_content ?>

    <?php if($value['use_overlay'] == 1) { ?><div class="overlay"></div><?php }; ?>

    <?php if( ($item_type == 'type2') && $video && auto_play_movie() ) { ?>
    <video class="video_wrap" preload="auto" muted playsinline <?php if($slider_item_total == 1) { echo "loop"; }; ?>>
     <source src="<?php echo esc_url(wp_get_attachment_url($video)); ?>" type="video/mp4" />
    </video>
    <?php
         } elseif( ($item_type == 'type3') && $youtube_url && auto_play_movie() ) {
           if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $youtube_url, $matches)) {
    ?>
    <div class="video_wrap">
     <div class="youtube_inner">
      <iframe id="youtube-player-<?php echo $i; ?>" class="youtube-player slide-youtube" src="https://www.youtube.com/embed/<?php echo esc_attr($matches[1]); ?>?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0&<?php if($slider_item_total > 1) { echo "loop=0"; } else { echo "playlist=" . esc_attr($matches[1]); }; ?>&playsinline=1" frameborder="0"></iframe>
     </div>
    </div>
    <?php
           };
         } else {
    ?>
    <?php if($image) { ?>
      <!-- cw_editor responsive hero image according to screen height  -->
      <!-- <div class="bg_image <?php if($image_mobile) { echo 'pc'; }; ?>" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div> -->
      <img src="<?php echo esc_attr($image[0]); ?>" class="bg_image <?php if($image_mobile) { echo 'pc'; }; ?>">
      <!-- cw_editor end  -->
    <?php }; ?>
    <?php if($image_mobile) { ?>
      <!-- cw_editor responsive hero image according to screen height  -->
      <!-- <div class="bg_image mobile" style="background:url(<?php echo esc_attr($image_mobile[0]); ?>) no-repeat center center; background-size:cover;"></div> -->
      <img src="<?php echo esc_attr($image_mobile[0]); ?>" class="bg_image mobile">
      <!-- cw_editor end  -->

    <?php }; ?>
    <?php }; ?>

    <?php if( (($item_type == 'type2') && $video && auto_play_movie()) || (($item_type == 'type3') && $youtube_url && auto_play_movie()) ) { ?>
    </div>
    <?php }; ?>

   </div><!-- END .item -->
   <?php
        $i++;
        endforeach;
   ?>
  </div><!-- END #header_slider -->

  <?php
       // ニュースティッカー -----------------------------------
       if($options[$device.'show_news_ticker']){
         $post_num = '5';
         $post_type = $options[$device.'news_ticker_post_type'];
         $post_order = $options[$device.'news_ticker_post_order'];
         $args = array( 'post_type' => $post_type, 'posts_per_page' => $post_num, 'orderby' => $post_order );
         $post_list = new wp_query($args);
         if($post_list->have_posts()):
  ?>
  <div id="index_news_ticker">
   <div class="post_list">
    <?php
         while($post_list->have_posts()): $post_list->the_post();
    ?>
    <article class="item">
     <a href="<?php the_permalink(); ?>">
      <time class="entry-date" datetime="<?php the_modified_time('c'); ?>"><span class="year"><?php the_time('Y'); ?></span><span class="month"><?php the_time('m'); ?></span><span class="line"></span><span class="date"><?php the_time('d'); ?></span></time>
      <h3 class="title"><span><?php the_title(); ?></span></h3>
     </a>
    </article>
    <?php endwhile; ?>
   </div>
  </div>
  <?php
         endif;
         wp_reset_query();
       };
  ?>

 </div><!-- END #header_slider_wrap -->
 <?php
        }; // END display_header_content
      }; // END front page
 ?>

