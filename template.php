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
function sources_theme_breadcrumb() {
  return sources_views_custom_breadcrumbs();
}

/**
 * Implements HOOK_preprocess_html().
 */
function sources_theme_preprocess_html(&$variables) {
  drupal_add_js('sites/all/libraries/cookie.js/jquery.cookie.js', 'file');
  if (!sources_theme_is_front_page()) {
    sources_theme_remove_front_page_class($variables);
  }
}

function sources_theme_is_front_page() {
  return (drupal_is_front_page() && !$_SERVER['QUERY_STRING']);
}

function sources_theme_remove_front_page_class(&$variables) {
  if (($key = array_search('front', $variables['classes_array'])) !== FALSE) {
    unset($variables['classes_array'][$key]);
  }
}

/**
 * Implements THEME_preprocess_views_view_fields().
 */
function sources_theme_preprocess_views_view_fields(&$vars) {
  if ($vars['view']->name == 'biblio_search_api') {
    $year = (!empty($vars['row']->_entity_properties['biblio_year'])) ? $vars['row']->_entity_properties['biblio_year'] : '';
    $parameters = sources_theme_url_parameters($vars);
    $publication_type = sources_theme_publication_type($vars);
    $title_info = sources_theme_content_title_info($year, $publication_type);
    $custom_link_wrapper_prefix = '<div class="source-icon-' . $publication_type . ' title-link-container"><span class="glyphicon shanticon-essays"></span>';
    $custom_link_wrapper_suffix = '</div>';

    switch ($vars['view']->current_display) {
      case 'page':
        $link = l($vars['row']->_entity_properties['title'] . $title_info, 'sources-search/biblio', array('query' => $parameters, 'html' => TRUE));
        $vars['fields']['title']->content = $custom_link_wrapper_prefix . $link . $custom_link_wrapper_suffix;
        break;
      case 'biblio_full':
        $title = $vars['row']->_entity_properties['title'] . $title_info;
        $vars['fields']['title']->content = $custom_link_wrapper_prefix . $title . $custom_link_wrapper_suffix;;
        break;
    }
  }
}

/**
 * Returns query parameters for source content link.
 *
 */
function sources_theme_url_parameters($vars) {
  $current_page = (!empty($_GET['page'])) ? intval($_GET['page']) : 0;
  $page = $vars['view']->row_index + (25 * $current_page);
  $query_strings = $_SERVER['QUERY_STRING'];
  parse_str($query_strings, $query_string_values);
  $parameters = array_replace($query_string_values, array('page' => $page));
  $parameters['current_nid'] = $vars['row']->entity;
  return $parameters;
}

/**
 * Returns publication type.
 *
 */
function sources_theme_publication_type($vars) {
  $publication_type_name = '';
  if (!empty($vars['row']->_entity_properties['biblio_publication_type'])) {
    $publication_type_id = $vars['row']->_entity_properties['biblio_publication_type'];
    $publication_type_name = db_query('SELECT name FROM {biblio_types} WHERE tid = :tid', array(':tid' => $publication_type_id))->fetchField();
  }
  return $publication_type_name;
}

/**
 * Returns year and publication type information.
 *
 */
function sources_theme_content_title_info($year, $publication_type) {
  if (!empty($publication_type)) {
    $publication_type = '<span class="publication-type">' . $publication_type . '</span>';
  }
  $publication_info = array($year, $publication_type);
  $information_output = '';
  $info_index = 1;
  foreach ($publication_info as $info) {
    if (!empty($info)) {
      if ($info_index > 1) {
        $information_output .= ', ' . $info;
      }
      else {
        $information_output .= $info;
      }
      $info_index++;
    }
  }
  $information_output = ' (' . $information_output . ')';
  return $information_output;
}
