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

function corvusbie_preprocess_username(&$variables) {
  $account = $variables['account'];
  $variables['extra'] = '';
  if (empty($account->uid)) {
    $variables['uid'] = 0;
    if (theme_get_setting('toggle_comment_user_verification')) {
      $variables['extra'] = ' (' . t('not verified') . ')';
    }
  }
  else {
    $variables['uid'] = (int) $account->uid;
  }

  // Set the name to a formatted name that is safe for printing and
  // that won't break tables by being too long. Keep an unshortened,
  // unsanitized version, in case other preprocess functions want to implement
  // their own shortening logic or add markup. If they do so, they must ensure
  // that $variables['name'] is safe for printing.
  $name = $variables['name_raw'] = format_username($account);
  $variables['name'] = check_plain($name);
  $variables['profile_access'] = user_access('access user profiles');
  $variables['link_attributes'] = array();

  // Populate link path and attributes if appropriate.
  if ($variables['uid'] && $variables['profile_access']) {

    // We are linking to a local user.
    $variables['link_attributes'] = array(
      'title' => t('View user profile.'),
    );
    $variables['link_path'] = 'user/' . $variables['uid'];
  }
  elseif (!empty($account->homepage)) {

    // Like the 'class' attribute, the 'rel' attribute can hold a
    // space-separated set of values, so initialize it as an array to make it
    // easier for other preprocess functions to append to it.
    $variables['link_attributes'] = array(
      'rel' => array(
        'nofollow',
      ),
    );
    $variables['link_path'] = $account->homepage;
    $variables['homepage'] = $account->homepage;
  }

  // We do not want the l() function to check_plain() a second time.
  $variables['link_options']['html'] = TRUE;

  // Set a default class.
  $variables['attributes_array'] = array(
    'class' => array(
      'username',
    ),
  );
}

