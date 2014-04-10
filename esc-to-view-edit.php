<?php
/**
 * Plugin Name:       ESC to Edit/View
 * Plugin URI:        http://github.com/twinbrother/esc-to-edit-view
 * Description:       Press ESC to edit any post/page
 * Version:           1.0.0
 * Author:            Taran Hubbert
 * Author URI:        http://twinbrother.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/twinbrother/esc-to-edit-view
 */
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function esc_to_view_edit() {
  global $post, $pagenow;

  wp_enqueue_script('esc-to-view-edit', plugins_url('', __FILE__).'/esc-to-view-edit.js', array('jquery'), '1.0.0', true);

  $url = false;
  if(is_admin()) {
    if('post.php' === $pagenow) {
      $url = get_permalink($post->ID);
    } elseif('edit.php' === $pagenow) {
      if('page' !== get_query_var('post_type')) {
        $url = get_post_type_archive_link(get_query_var('post_type'));
      }
    }
    $url = (!$url)?home_url():$url;
  } else {
    $url = admin_url();
    if(is_post_type_archive(get_query_var('post_type'))) {
      $url .= '/edit.php?post_type='.get_query_var('post_type');
    } elseif ($post->ID) {
      $url .= '/post.php?post='.$post->ID.'&action=edit';
    }
  }

  wp_localize_script('esc-to-view-edit', 'escToViewEdit', array(
    'url' => $url,
  ));
}
add_action('admin_enqueue_scripts', 'esc_to_view_edit');
add_action('wp_enqueue_scripts', 'esc_to_view_edit');
