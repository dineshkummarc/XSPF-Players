<?php
// $Id: theme.inc,v 1.1.2.1 2009/04/07 19:31:30 arthuregg Exp $

/**
 * @file theme.inc
 *
 * An array of preprocessors to fill variables for templates and helper
 * functions to make theming easier.
 */

/**
 * Preprocess an RSS feed
 */
function template_preprocess_xspf_playlist_views_view_xspf_playlist(&$vars) {
  global $base_url;
  global $language;

  $view     = &$vars['view'];
  $options  = &$vars['options'];
  $items    = &$vars['rows'];

  $style    = &$view->style_plugin;

  $vars['annotation'] = check_plain(decode_entities(strip_tags($options['annotation'])));
  $vars['title'] = check_plain($view->get_title());

  // Figure out which display which has a path we're using for this feed. If there isn't
  // one, use the global $base_url
  $link_display_id = $view->display_handler->get_link_display();
  if ($link_display_id && !empty($view->display[$link_display_id])) {
    $path = $view->display[$link_display_id]->handler->get_path();
  }

  if ($path) {
    $path = $view->get_url(NULL, $path);
    $url_options = array('absolute' => TRUE);
    if (!empty($view->exposed_raw_input)) {
      $url_options['query'] = $view->exposed_raw_input;
    }

    // Compare the link to the default home page; if it's the default home page, just use $base_url.
    if ($path == variable_get('site_frontpage', 'node')) {
      $path = '';
    }

    $vars['link'] = check_url(url($path, $url_options));
  }

  $vars['langcode'] = check_plain($language->language);
  $vars['namespaces'] = drupal_attributes($style->namespaces);
  $vars['items'] = $items;

  drupal_set_header('Content-Type: text/xml; charset=utf-8');
}

/**
 * Default theme function for all RSS rows.
 */
function template_preprocess_xspf_playlist_views_view_row_node_xspf_playlist(&$vars) {
}
