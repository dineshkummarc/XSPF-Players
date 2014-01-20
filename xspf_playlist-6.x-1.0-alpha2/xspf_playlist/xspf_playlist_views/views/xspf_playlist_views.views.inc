<?php
// $Id: xspf_playlist_views.views.inc,v 1.1.2.1 2009/04/07 19:31:30 arthuregg Exp $

/**
 * @file
 * Provides XSPF playlist support for the Views module.
 */

/**
 * Implementation of hook_views_plugins
 */
function xspf_playlist_views_views_plugins() {
  $path = drupal_get_path('module', 'xspf_playlist_views');
  return array(
    'module' => 'xspf_playlist_views',
    'style' => array(
      'xspf_playlist' => array(
        'title' => t('XSPF Playlist'),
        'help' => t('Generates an XSPF playlist from a view.'),
        'handler' => 'xspf_playlist_views_plugin_style_xspf_playlist',
        'path' => "$path/views",
        'theme' => 'xspf_playlist_views_view_xspf_playlist',
        'theme path' => "$path/theme",
        'theme file' => 'theme.inc', 
        'uses row plugin' => TRUE,
        'uses options' => TRUE,
        'type' => 'feed',
      ),
    ),
    'row' => array(
      'node_xspf_playlist' => array(
        'title' => t('Node XSPF'),
        'help' => t('Display the node with standard node view.'),
        'handler' => 'xspf_playlist_views_plugin_row_node_xspf_playlist',
        'path' => "$path/views",
        'theme' => 'xspf_playlist_views_view_row_node_xspf_playlist',
        'theme path' => "$path/theme",
        'theme file' => 'theme.inc', 
        'base' => array('node'), // only works with 'node' as base.
        'uses options' => FALSE,
        'type' => 'feed',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_handlers().
 */
/*function xspf_playlist_views_views_handlers() {
  return array(
    'handlers' => array(
      'xspf_playlist_views_handler_filter_has_playlist' => array(
        'parent' => 'views_handler_filter_boolean_operator',
      ),
    ),
  );
}*/

/**
 * Implementation of hook_views_data().
 */
/*function xspf_playlist_views_views_data() {
  $data = array();
  
  $data['xspf_playlist_thumb']['table']['group'] = t('XSPF Playlist');

  // Specialized is null/is not null filter.
  $data['xspf_playlist_thumb']['has_playlist'] = array(
  	'field' => array(
        'title' => t('Has XSPF playlist.'),
        'help' => t('Filter to ensure content has or does not have an XSPF playlist.'),
  		'views_handler_field_node',
    ),
    'filter' => array(
        'handler' => 'xspf_playlist_views_handler_filter_has_playlist',
    ),
  );
  return $data;
}*/