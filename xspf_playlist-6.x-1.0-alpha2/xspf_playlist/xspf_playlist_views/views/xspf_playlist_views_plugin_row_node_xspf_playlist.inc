<?php
// $Id: xspf_playlist_views_plugin_row_node_xspf_playlist.inc,v 1.1.2.1 2009/04/07 19:31:30 arthuregg Exp $
/**
 * @file
 * Contains the node RSS row style plugin.
 */

/**
 * Plugin which performs a node_view on the resulting object
 * and formats it as an RSS item.
 */
class xspf_playlist_views_plugin_row_node_xspf_playlist extends views_plugin_row {
  function option_definition() {
    $options = parent::option_definition();
    return $options;
  }

  function render($row) {
    // For the most part, this code is taken from node_feed() in node.module
    global $base_url;

    // Load the specified node:
    $node = node_load($row->nid);
    $node->build_mode = NODE_BUILD_RSS;

    // convert the node to playlist items
    if (!$item = xspf_playlist_node_items($node)) {
      return; // could not generate a playlist item from the node
    }

    // set the namespace
    $this->view->style_plugin->namespaces = array('xmlns' => 'http://xspf.org/ns/0/');

    return theme($this->theme_functions(), $this->view, $this->options, $item);
  }
}
