/**
 * @file resume_builder.js
 *
 */

(function ($, Drupal, once) {

  'use strict';

  if(window.innerWidth > 767){
    setTimeout(function(){
      /**
       * If content area's height is grater than the sidebar, extend the sidebar to the height of the content area.
       *
       */
      var sidebar_height = $('.region-sidebar-first').height()+10;
      var content_height = $(".bordered-row").height();
      if(content_height > sidebar_height){
        $(".region-sidebar-first").height(content_height);
      }
    }, 1000);
  }


})(jQuery, Drupal, once);
