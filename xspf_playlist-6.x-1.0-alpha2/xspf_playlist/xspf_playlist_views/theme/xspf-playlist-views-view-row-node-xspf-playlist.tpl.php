<?php
// $Id: xspf-playlist-views-view-row-node-xspf-playlist.tpl.php,v 1.1.2.1 2009/04/07 19:31:30 arthuregg Exp $

/**
 * @file xspf-playlist-views-view-row-node-xspf-playlist.tpl.php
 * Default view template to display a item in an XSPF playlist.
 *
 * @ingroup views_templates
 */

?>
<?php foreach($row as $item): ?>
  <track>
    <?php print format_xml_elements($item); ?>
  </track>
<?php endforeach; ?>