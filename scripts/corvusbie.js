jQuery(document).ready(function($) {
  $("#admin-menu").detach().prependTo('#page');

  $("#superfish-1-accordion").detach().appendTo('#menubar-wrapper');

  $("#menu-bar li.sf-depth-2.last img").each(function(){
    var parent = $(this).parent();
    $(this).detach().prependTo(parent);
  });
});

//Subject Guide Accordion
jQuery(document).ready(function($) {

  // Add permalinks to each detailed guide accordion content div.
  $('div.detailed-guide-accordion-content').each(function() {
    var anchor = '#' + $(this).closest('div.content').find('a.guide-accordion-header-wrapper').attr('id');
    var anchorLink = '<a tabindex="-1" class="guide-accordion-header-permalink" href="'+anchor+'" title="Permalink to this section">¶</a>';
    $(this).append(anchorLink);
  });

  // On click of link around header, toggle classes for headers and content.
  $('a.guide-accordion-header-wrapper').click(function(e) {
    e.preventDefault();
    $(this).children('h2,h3').toggleClass('guide-accordion-header-collapsed');
    $(this).closest('div.content,section').find('div.guide-accordion-content').toggleClass('guide-accordion-content-collapsed');
  });

  // If the hash is an id of a accordion header wrapper a, emulate a click.
  // This expands the content when using the permalinks.
  // The extra call to filter() keeps this from being used to click on other elements on the page.
  var hash = window.location.hash;
  if ( hash !== "" && hash !== "#" ){
    $(hash).filter("a.guide-accordion-header-wrapper").click();
  }

});

//Course Reserves search
function submit_form() {
  var selind = document.forms.course_reserves_search.search_action.selectedIndex;
  var selval = document.forms.course_reserves_search.search_action[selind].value;
  document.forms.course_reserves_search.action=selval;
  document.forms.course_reserves_search.submit();
}

//Journal Articles in Scholars Portal search
function search_scholars_portal_journals() {
var url="http://proxy.library.carleton.ca/login?url=http://journals2.scholarsportal.info./search-advanced.xqy?q=";
var input_element = document.getElementById("search_terms");
var end_of_url = "&search_in=anywhere&date_from=&date_to=&sort=relevance&sub=";
document.location = url + encodeURIComponent(input_element.value) + end_of_url;
}

//Subject Guides - Limit Number of Accordions
jQuery(document).ready(function($) {

  function checkAndDisable(){
    var index = $('#edit-field-detailed-guide-section input[name="field_detailed_guide_section_add_more"]').parent().prev().find('tr:last').index();
    if (index >= 4) {
      $('#edit-field-detailed-guide-section input[name="field_detailed_guide_section_add_more"]').attr( "disabled", true ).after('<span id="guide-section-limit-reached-message">Contact Shelley or Kevin if you require additional sections.</span>');
    }
  }
  checkAndDisable();

  var target = document.getElementById('edit-field-detailed-guide-section');
  if (target != null) {
    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
    var myObserver = new MutationObserver(function(mutations) {
      checkAndDisable();
    });
    var config = { childList:true };
    myObserver.observe(target, config);
  }

});

// Close the sidr menu on desktop.
(function ($) {

  Drupal.behaviors.SidrMenuClose = {
    attach: function (context, settings) {

      if ($.browser.msie && parseFloat($.browser.version) <= 8) {
        return;
      }

      var activeTheme = Drupal.settings["ajaxPageState"]["theme"];
      var themeSettings = Drupal.settings['adaptivetheme'];

      if ((typeof themeSettings == 'undefined') || (typeof themeSettings[activeTheme] == 'undefined')) {
        return;
      }

      var breakpoint = themeSettings[activeTheme]['media_query_settings']['bigscreen'];
      var mm = window.matchMedia(breakpoint);
      mm.addListener(cb);

      // Callback
      function cb(e){
        if (e.matches) {
          $.sidr('close', 'sidr-0');
        }
      }
    }
  };
})(jQuery);


