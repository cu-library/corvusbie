<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 *
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "corvusbie" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "corvusbie".
 * 2. Uncomment the required function to use.
 */


/**
 * Preprocess variables for the html template.
 */
function corvusbie_preprocess_html(&$vars) {
  global $theme_key;

  // Add the external CSS for fonts
  // drupal_add_css('https://fonts.googleapis.com/css?family=Roboto:300,400', array('type' => 'external'));

  drupal_add_css('https://cloud.typography.com/6307052/6144772/css/fonts.css', array('type' => 'external'));

  // Add body classes to course guide book pages
  $courseguidepathprefix = 'research/course-guides/';
  if (strncmp(request_path(), $courseguidepathprefix, strlen($courseguidepathprefix)) === 0 ){
    $vars['classes_array'][] = 'course-guide-child-page';
  }

  // Add body classes to find/ pages
  $findpathprefix = 'find/';
  if (strncmp(request_path(), $findpathprefix, strlen($findpathprefix)) === 0 ){
    $vars['classes_array'][] = 'find-child-page';
  }

  // Add body classes to services/ child pages
  $servicespathprefix = 'services/';
  if (strncmp(request_path(), $servicespathprefix, strlen($servicespathprefix)) === 0 ){
    $vars['classes_array'][] = 'services-child-page';
  }
}

/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function corvusbie_process_html(&$vars) {
}
// */


/**
 * Override or insert variables for the page templates.
 */
/* -- Delete this line if you want to use these functions
function corvusbie_preprocess_page(&$vars) {
}
function corvusbie_process_page(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function corvusbie_preprocess_node(&$vars) {
}
function corvusbie_process_node(&$vars) {
}
// */

/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function corvusbie_preprocess_comment(&$vars) {
}
function corvusbie_process_comment(&$vars) {
}
// */


/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function corvusbie_preprocess_block(&$vars) {
}
function corvusbie_process_block(&$vars) {
}
// */

function corvusbie_preprocess_field(&$vars) {
  if ($vars['element']['#field_name'] == 'field_link_to_detailed_guide') {
    foreach ($vars['items'] as $delta => $item) {
      $vars['items'][$delta]['#label'] = $vars['items'][$delta]['#label'] . " Subject Guide: Detailed Version";
    }
  } elseif ($vars['element']['#field_name'] == 'field_link_to_quick_guide') {
    foreach ($vars['items'] as $delta => $item) {
      $vars['items'][$delta]['#label'] = $vars['items'][$delta]['#label'] . " Quick Guide";
    }
  }
}

function corvusbie_admin_menu_output_alter(&$content) {
  $content['menu']['imce'] = array(
    "#title" => "File Browser",
    "#href" => "imce",
    "#weight" => -20,
    );
}

