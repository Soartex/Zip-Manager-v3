// Make sure that we are using popups for edits
$.fn.editable.defaults.mode = 'popup';

// Enable editing when a object has the class of "editable"
// Post to the local post.php
$(function(){
  $('.editable').editable({
     url: './post.php' 
  });
});