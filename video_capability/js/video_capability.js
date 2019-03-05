/**
 * @file
 * Attaches functionality to video capability block.
 */
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.video_capabilityBehavior = {
    attach: function (context, settings) {
      // can access setting from 'drupalSettings';
      var videoPlayerHeight = drupalSettings.video_capability_.video_capability_videocapabilityblock.video_player_height;
      var videoPlayerWidth = drupalSettings.video_capability_.video_capability_videocapabilityblock.video_player_width;
      $('#block-videocapabilityblock').css('height', videoPlayerHeight);
      $('#block-videocapabilityblock').css('width', videoPlayerWidth);
   	}
  };
})(jQuery, Drupal, drupalSettings);