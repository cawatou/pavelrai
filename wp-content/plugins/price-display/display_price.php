<?php
/*
Plugin Name: price_display
Plugin URI: http://pavelrai.ru
Description: Плагин позволяет устанавливать отображение цены у товара по категориям
Version: 1.0
Author: cawatou@gmail.com
Author URI: cawatou@gmail.com
License: GPL2

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : EMAIl автора плагина)
 
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

add_action('admin_menu', 'price_display');

function price_display() {
    add_menu_page( 'Отображение цен', 'Отображение цен', 'manage_options',
        'price-display/index.php', '', plugins_url( '/dollar.png', __FILE__ ) );
}
?>