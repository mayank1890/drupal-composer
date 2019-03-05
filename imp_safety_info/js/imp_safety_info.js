/**
 * @file
 * Attaches functionality to imp_safety_info block.
 */
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.imp_safety_infoBehavior = {
    attach: function (context, settings) {
    	// can access setting from 'drupalSettings';
      var isiHeight = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_height;
    	var isiPaddingLeft = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_text_padding_left;
  	  var isiPaddingRight = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_text_padding_right;
      var isiBackgroundColor = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_background_color;
      var isiFontColor = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_font_color;
      var isiBorderStyle = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_border_style;
      var isiBorderColor = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_border_color;
      var isiBorderWidth = drupalSettings.imp_safety_info_.imp_safety_info_importantsafetyinformationblock.isi_border_width;

      $('#block-importantsafetyinformationblock').css('height', isiHeight);
    	$('#block-importantsafetyinformationblock').css('padding-left', isiPaddingLeft);
    	$('#block-importantsafetyinformationblock').css('padding-right', isiPaddingRight);
      $('#block-importantsafetyinformationblock').css('background-color', isiBackgroundColor);
      $('#block-importantsafetyinformationblock').css('color', isiFontColor);
      $('#block-importantsafetyinformationblock').css('border-style', isiBorderStyle);
      $('#block-importantsafetyinformationblock').css('border-color', isiBorderColor);
      $('#block-importantsafetyinformationblock').css('border-width', isiBorderWidth);

   	}
};
})(jQuery, Drupal, drupalSettings);