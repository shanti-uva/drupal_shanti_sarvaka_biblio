<?php

/**
 * @file
 * template.php
 */
 
 /**
  *   This is the template.php file for a child sub-theme of the Shanti Sarvaka theme.
  *   Use it to implement custom functions or override existing functions in the theme. 
  */ 

/**
 * Implements HOOK_breadcrumb
 * Customizes output of breadcrumbs
 */
function csc_theme_breadcrumb() {
  return csc_views_custom_breadcrumbs();
}

/**
 * Implements HOOK_preprocess_html().
 */
function csc_theme_preprocess_html(&$variables) {
  if (!csc_theme_is_front_page()) {
    csc_theme_remove_front_page_class($variables);
  }
}

function csc_theme_is_front_page() {
  return (drupal_is_front_page() && !$_SERVER['QUERY_STRING']);
}

function csc_theme_remove_front_page_class(&$variables) {
  if (($key = array_search('front', $variables['classes_array'])) !== false) {
    unset($variables['classes_array'][$key]);
  }
}
