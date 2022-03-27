/**
   * Easy selector helper function
   */
 const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

/**
   * Preloader
*/
 let preloader = select('#preloader');
 if (preloader) {
   window.addEventListener('load', () => {
     preloader.remove()
   });
 }

 function makeFooterSticky() {
  //position footer at the bottom
  let fheight = $('.footer-content').outerHeight(true);
  $('body').css('margin-bottom', fheight + 'px');
  $('.footer-content').css('height', fheight + 'px');
  $('.footer-content').css('min-height', fheight + 'px');
}

$(function() {
  makeFooterSticky();

    $(window).on('resize', function () {
        makeFooterSticky();
    });

    let maxHeight = 0;
    let articles = jQuery('.strategic-partner-items .partner-card');
  	  	
  	for (i = 0; i < articles.length; i++) {
    	let article = articles[i];
      	let height =  jQuery(article).height();
      
      	if (parseFloat(height) > maxHeight) {
          maxHeight = parseFloat(height);
        }
	}
  
  	if (maxHeight > 0) {
    	for (i = 0; i < articles.length; i++) {
          let article = articles[i];
          
          if (jQuery(article).height() !== maxHeight) {
            jQuery(article).height(maxHeight);            
          }
        }  
    }
  

  //   $('.strategic-partner-items').slick({
  //     dots: true,
  //     infinite: true,
  //     speed: 800,
  //     autoplay: true,
  //     autoplaySpeed: 2000,
  //     slidesToShow: 10,
  //     slidesToScroll: 10,
  //     responsive: [{
  //             breakpoint: 1024,
  //             settings: {
  //                 slidesToShow: 6,
  //                 slidesToScroll: 6,
  //                 infinite: true,
  //                 dots: true
  //             }
  //         },
  //         {
  //             breakpoint: 600,
  //             settings: {
  //                 slidesToShow: 4,
  //                 slidesToScroll: 4
  //             }
  //         },
  //         {
  //             breakpoint: 480,
  //             settings: {
  //                 slidesToShow: 3,
  //                 slidesToScroll: 3
  //             }
  //         }
  
  //     ]
  // });
});