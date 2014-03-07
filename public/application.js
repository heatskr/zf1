/**
 * @file: application.js
 */
$(function() {
  // permissions/index
  $('.dropdown').mouseenter(function(evt){
    $(this).find('ul:first').show();
  });
  $('.dropdown').mouseleave(function(evt){
    $(this).find('ul:first').hide();
  });
});
