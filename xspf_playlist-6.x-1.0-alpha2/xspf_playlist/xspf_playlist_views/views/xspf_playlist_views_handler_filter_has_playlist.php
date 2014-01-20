<?php
// $Id: xspf_playlist_views_handler_filter_has_playlist.php,v 1.1.2.1 2009/04/07 19:31:30 arthuregg Exp $

/**
 * @file
 * Contains the flagged content filter handler.
 */

/**
 * Handler to filter for content that has not been flagged.
 *
 * @ingroup views
 */
class xspf_playlist_views_handler_filter_has_playlist extends views_handler_filter_boolean_operator {
  function options(&$options) {
    parent::options($options);
    $options['value'] = 1;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['value']['#type'] = 'radios';
    $form['value']['#title'] = t('Status');
    $form['value']['#options'] = array(1 => t('Has XSPF playlist'), 0 => t('Does not have XSPF playlist'));
    $form['value']['#default_value'] = empty($this->options['value']) ? 0 : $this->options['value'];
    $form['value']['#description'] = '<p>' . t('Filter nodes if they have a playlist. Use 0 to return all items on the playlist..') . '</p>';
  }

  function query() {
    $operator = $this->value ? 'IS NOT' : 'IS';
    $this->query->add_where($this->options['group'], $this->relationship .'.uid '. $operator .' NULL');
  }
}
