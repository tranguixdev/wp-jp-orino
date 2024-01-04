<?php
     $options = get_design_plus_option();

     if(!is_mobile() && $options['show_index_slider']) {
       $index_slider = $options['index_slider'];
       $device = '';
     } elseif(is_mobile() && ($options['mobile_show_index_slider'] == 'type2') ) {
       $index_slider = $options['mobile_index_slider'];
       $device = 'mobile_';
     } elseif(is_mobile() && ($options['mobile_show_index_slider'] == 'type1') ) {
       $index_slider = $options['index_slider'];
       $device = '';
     }

     $slider_item_total = count($index_slider);
?>

  var slideWrapper = $('#header_slider'),
      iframes = slideWrapper.find('.youtube-player'),
      ytPlayers = {},
      timers = { slickNext: null };

  // YouTube IFrame Player API script load
  if ($('#header_slider .youtube-player').length) {
    if (!$('script[src="//www.youtube.com/iframe_api"]').length) {
      var tag = document.createElement('script');
      tag.src = 'https://www.youtube.com/iframe_api';
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
  }

  // YouTube IFrame Player API Ready
  window.onYouTubeIframeAPIReady = function(){
    slideWrapper.find('.youtube-player').each(function(){
      var ytPlayerId = $(this).attr('id');
      if (!ytPlayerId) return;
      var player = new YT.Player(ytPlayerId, {
        events: {
          onReady: function(e) {
            $('#'+ytPlayerId).css('opacity', 0).css('pointerEvents', 'none');
            iframes = slideWrapper.find('.youtube-player');
            ytPlayers[ytPlayerId] = player;
            ytPlayers[ytPlayerId].mute();
            ytPlayers[ytPlayerId].lastStatus = -1;
            var item = $('#'+ytPlayerId).closest('.item');
            if (item.hasClass('slick-current')) {
              playPauseVideo(item, 'play');
            }
          },
          onStateChange: function(e) {
            if (e.data === 0) { // ended
              if (slideWrapper.find('.item').length == 1) {<?php // youtubeスライド1枚のみのループ処理 ?>
                var slide = slideWrapper.find('.slick-current');
                slide.css('transition', 'none').removeClass('animate');
                slide.find('.animate_item, .animate_item span').css('transition', 'none').removeClass('animate');
                setTimeout(function(){
                  slide.removeAttr('style');
                  slide.find('.animate_item, .animate_item span').removeAttr('style');
                  slide.addClass('animate');
                  playPauseVideo(slide, 'play');
                }, 20);
              } else {
                $('#'+ytPlayerId).stop().css('opacity', 0);
                if ($('#'+ytPlayerId).closest('.item').hasClass('slick-current')) {
                  if (timers.slickNext) {
                    clearTimeout(timers.slickNext);
                    timers.slickNext = null;
                  }
                  slideWrapper.slick('slickNext');
                }
              }
            } else if (e.data === 1) { // play
              $('#'+ytPlayerId).not(':animated').css('opacity', 1);
              if (slideWrapper.find('.item').length > 1) {
                var slide = $('#'+ytPlayerId).closest('.item');
                var slickIndex = slide.attr('data-slick-index') || 0;
                clearInterval(timers[slickIndex]);
                timers[slickIndex] = setInterval(function(){
                  var state = ytPlayers[ytPlayerId].getPlayerState();
                  if (state != 1 && state != 3) {
                    clearInterval(timers[slickIndex]);
                  } else if (ytPlayers[ytPlayerId].getDuration() - ytPlayers[ytPlayerId].getCurrentTime() < 1) {
                    clearInterval(timers[slickIndex]);
                    if (timers.slickNext) {
                      clearTimeout(timers.slickNext);
                      timers.slickNext = null;
                    }
                    slideWrapper.slick('slickNext');
                  }
                }, 200);
              }
            } else if (e.data === 3) { // buffering
              if (ytPlayers[ytPlayerId].lastStatus === -1) {
                $('#'+ytPlayerId).delay(100).animate({opacity: 1}, 400);
              }
            }
            ytPlayers[ytPlayerId].lastStatus = e.data;
          }
        }
      });
    });
  };

  // play or puase video
  function playPauseVideo(slide, control){
    if (!slide) {
      slide = slideWrapper.find('.slick-current');
    }
    // animate caption and logo
    function captionAnimation() {
      if( !$('body').hasClass('stop_index_slider_animation') ){
        if( slide.hasClass('first_item') ){
          $('#header_logo').addClass('animate');
          $('#drawer_menu_button').addClass('animate');
          $('#index_news_ticker').addClass('animate');
          $('#header_logo').on('animationend webkitAnimationEnd oAnimationEnd mozAnimationEnd', function(){
<?php if($options[$device.'show_index_fixed_content']){ ?>
            $("#index_fixed_content .animate_item").each(function(i){
              $(this).delay(i *700).queue(function(next) {
                $(this).addClass('animate');
                next();
              });
            });
<?php } else { ?>
            $(".first_animate_item").each(function(i){
              $(this).delay(i *700).queue(function(next) {
                $(this).addClass('animate');
                next();
              });
            });
<?php }; ?>
          });
        } else {
          slide.find(".animate_item").each(function(i){
            $(this).delay(i *700).queue(function(next) {
              $(this).addClass('animate');
              next();
            });
          });
        }
      }
    }
    // youtube item --------------------------
    if (slide.hasClass('youtube')) {
      var ytPlayerId = slide.find('.youtube-player').attr('id');
      if (ytPlayerId) {
        switch (control) {
          case 'play':
            if (ytPlayers[ytPlayerId]) {
              ytPlayers[ytPlayerId].seekTo(0, true);
            }
            // breakしない
          case 'resume':
            if (ytPlayers[ytPlayerId]) {
              ytPlayers[ytPlayerId].playVideo();
            }
            if( slide.hasClass('first_item') ){
              setTimeout(function(){
                captionAnimation();
              }, 1500);
            } else {
              setTimeout(function(){
                captionAnimation();
              }, 2500);
            }
            if (timers.slickNext) {
              clearTimeout(timers.slickNext);
              timers.slickNext = null;
            }
            break;
          case 'pause':
            slide.find(".animate_item").removeClass('animate');
            if (ytPlayers[ytPlayerId]) {
              ytPlayers[ytPlayerId].pauseVideo();
            }
            if(slide.hasClass('first_item')){
              setTimeout(function(){
                slide.removeClass('first_item');
              }, 1000);
            }
            break;
          case 'pauseDrawerOpen':
            slide.find(".animate_item").removeClass('animate');
            if (ytPlayers[ytPlayerId]) {
              ytPlayers[ytPlayerId].pauseVideo();
            }
            break;
        }
      }
    // video item ------------------------
    } else if (slide.hasClass('video')) {
      var video = slide.find('video').get(0);
      if (video) {
        switch (control) {
          case 'play':
            video.currentTime = 0;
            // breakしない
          case 'resume':
            video.play();
            if( slide.hasClass('first_item') ){
              setTimeout(function(){
                captionAnimation();
              }, 1500);
            } else {
              setTimeout(function(){
                captionAnimation();
              }, 2500);
            }
            var slickIndex = slide.attr('data-slick-index') || 0;
            clearInterval(timers[slickIndex]);
            timers[slickIndex] = setInterval(function(){
              if (video.paused) {
                // clearInterval(timers[slickIndex]);
              } else if (video.duration - video.currentTime < 2) {
                clearInterval(timers[slickIndex]);
                if (timers.slickNext) {
                  clearTimeout(timers.slickNext);
                  timers.slickNext = null;
                }
                slideWrapper.slick('slickNext');
              }
            }, 200);
            break;
          case 'pause':
            slide.find(".animate_item").removeClass('animate animate_mobile');
            video.pause();
            if(slide.hasClass('first_item')){
              setTimeout(function(){
                slide.removeClass('first_item');
              }, 1000);
            }
            break;
          case 'pauseDrawerOpen':
            slide.find(".animate_item").removeClass('animate animate_mobile');
            video.pause();
            break;
        }
      }
    // normal image item --------------------
    } else if (slide.hasClass('image_item')) {
      switch (control) {
        case 'play':
        case 'resume':
          if( slide.hasClass('first_item') ){
            setTimeout(function(){
              captionAnimation();
            }, 1500);
          } else {
            setTimeout(function(){
              captionAnimation();
            }, 2500);
          }
          if (timers.slickNext) {
            clearTimeout(timers.slickNext);
            timers.slickNext = null;
          }
          timers.slickNext = setTimeout(function(){
            slideWrapper.slick('slickNext');
          }, <?php echo absint($options[$device . 'index_slider_time']); ?>);
          break;
        case 'pause':
          slide.find(".animate_item").removeClass('animate animate_mobile');
          if(slide.hasClass('first_item')){
            setTimeout(function(){
              slide.removeClass('first_item');
            }, 1000);
          }
          break;
        case 'pauseDrawerOpen':
          slide.find(".animate_item").removeClass('animate animate_mobile');
          if (timers.slickNext) {
            clearTimeout(timers.slickNext);
            timers.slickNext = null;
          }
          break;
      }
    }
  }


  // resize video
  function video_resize(object){
    var slider_height = $('#header_slider').innerHeight();
    var slider_width = slider_height*(16/9);
    var win_width = $(window).width();
    var win_height = win_width*(9/16);
    if(win_width > slider_width) {
      object.addClass('type1');
      object.removeClass('type2');
      object.css({'width': '100%', 'height': win_height});
    } else {
      object.removeClass('type1');
      object.addClass('type2');
      object.css({'width':slider_width, 'height':slider_height });
    }
  }


  // Adjust height for mobile device
  function adjust_height(){
    var winH = $(window).innerHeight();
    
    $('#header_slider_wrap').css('height', winH);
    $('#header_slider').css('height', winH);
    $('#header_slider .item').css('height', winH);
    $('#header_slider .slick-track').css('height', winH);
    
    /** cw_editor responsive hero image according to screen height  */

    var winW = $(window).innerWidth();
    var agent = '<?php echo $_SERVER['HTTP_USER_AGENT'];?>';
    var iphoneLandScape = false;
    if (agent.indexOf('iPhone')!= -1 && winW > winH) {
      iphoneLandScape = true;

      $('.bg_image.mobile').hide();
      $('.bg_image.pc').show();
    }

    if ($('#header_slider .slick-track .slick-slide img.mobile').is(':hidden') || iphoneLandScape) {
      
      var childImgH = $('#header_slider .slick-track .slick-slide img').height();
      $('#header_slider_wrap').css('height', childImgH);
      $('#header_slider').css('height', childImgH);
      $('#header_slider .item').css('height', childImgH);
      $('#header_slider .slick-track').css('height', childImgH);
    }

    /** cw_editor end  */
  }


  // Clip path slide-in animation
  var slideinVars = {
  	elem: null,
    startTimestamp: null,
    frameId: null,
    effectTime: 2400,
    offsetTime: null,
    animationFrame: function (timestamp) {
      var diffTimestamp, progressRatio;

      if (!slideinVars.startTimestamp) {
        slideinVars.startTimestamp = timestamp;
      }

      diffTimestamp = timestamp - slideinVars.startTimestamp - slideinVars.offsetTime;

      // iPhoneで2回目コールバックのrequestAnimationFrameが遅延する対策
      if (slideinVars.offsetTime === null && diffTimestamp > 0) {
        if (diffTimestamp > 70) {
          slideinVars.offsetTime = diffTimestamp;
          diffTimestamp = 0;
        } else {
          slideinVars.offsetTime = 0;
        }
      }

      progressRatio = diffTimestamp / (slideinVars.effectTime - slideinVars.offsetTime);

      if (progressRatio <= 0) {
        progressRatio = 0;
      } else if (progressRatio >= 1) {
        progressRatio = 1;
      } else {
        // Easing easeOutExpo
        progressRatio = 1 - Math.pow(2, -10 * progressRatio);
      }

      if (progressRatio >= 1) {
        slideinVars.elem.style.clipPath = null;
        slideinVars.frameId = null;
        return;
      } else {
        slideinVars.elem.style.clipPath = 'inset(0 0 0 ' + Math.floor((1 - progressRatio) * 1000000) / 10000 + '%)';
      }

      if (window.requestAnimationFrame) {
        slideinVars.frameId = window.requestAnimationFrame(slideinVars.animationFrame);
      } else {
        slideinVars.frameId = setTimeout(function() {
          slideinVars.animationFrame(performance.now());
        }, 1000/60);
      }
    }
  };
  function clipPathSlideIn($slide) {
    slideinVars.elem = $slide.get(0);
    slideinVars.startTimestamp = null;
    if (window.requestAnimationFrame) {
      if (slideinVars.frameId) {
        window.cancelAnimationFrame(slideinVars.frameId);
      }
      slideinVars.frameId = window.requestAnimationFrame(slideinVars.animationFrame);
    } else {
      if (slideinVars.frameId) {
        clearInterval(slideinVars.frameId);
      }
      slideinVars.frameId = setTimeout(function() {
        slideinVars.animationFrame(performance.now());
      }, 1000/60);
    }
  }


  // DOM Ready
  $(function() {
    slideWrapper.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
      if (currentSlide == nextSlide) return;
      var $currentSlide = slick.$slides.eq(currentSlide);
      var $nextSlide = slick.$slides.eq(nextSlide);
      $currentSlide.addClass('slick-last-active');
      $nextSlide.addClass('animate');
      if ($nextSlide.hasClass('image_item')) {
        clipPathSlideIn($nextSlide);
      }
      setTimeout(function(){
        playPauseVideo($currentSlide, 'pause');
      }, slick.options.speed);
      playPauseVideo($nextSlide, 'play');
    });
    slideWrapper.on('afterChange', function(event, slick, currentSlide) {
      slick.$slides.filter('.slick-last-active').removeClass('slick-last-active');
      slick.$slides.not('.slick-current').filter('.animate').removeClass('animate');
    });

    // drawer open/close event
    $(document).on('drawerOpen', function(){
      playPauseVideo(slideWrapper.find('.slick-current'), 'pauseDrawerOpen');
      if (timers.slickNext) {
        clearTimeout(timers.slickNext);
        timers.slickNext = null;
      }
    }).on('drawerClose', function(){
      playPauseVideo(slideWrapper.find('.slick-current'), 'resume');
    });

    //start the slider
    slideWrapper.slick({
      slide: '.item',
      infinite: true,
      dots: false,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      accessibility: false,
      draggable: false,
      swipe: false,
      touchMove: false,
      pauseOnFocus: false,
      pauseOnHover: false,
      autoplay: false,
      fade: true,
      autoplaySpeed:<?php echo absint($options[$device . 'index_slider_time']); ?>,
      speed: 2400,
    });

    // initialize / first animate
    adjust_height();
    video_resize($('.video_wrap'));
    playPauseVideo($('#header_slider .item1'), 'play');
    $('#header_slider .first_item').addClass('animate');
  });

  // Resize event
  var currentWidth = $(window).innerWidth();
  $(window).on('resize', function(){
    adjust_height();
    if (currentWidth == $(this).innerWidth()) {
      return;
    } else {
      video_resize($('.video_wrap'));
    };
  });
