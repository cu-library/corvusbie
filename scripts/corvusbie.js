//Move the admin menu to the top of the page
jQuery(document).ready(function($) {
  $("#admin-menu").detach().prependTo('#page');
});
