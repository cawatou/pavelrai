<?php
/*
Plugin Name: dollar_course
Plugin URI: http://pavelrai.ru
Description: Плагин позволяет устанавливать курс доллара
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

add_action('admin_menu', 'dollar_course');

function dollar_course() {
    add_menu_page( 'Курс доллара', 'Курс доллара', 'manage_options',
        'dollar-course/index.php', '', plugins_url( '/dollar.png', __FILE__ ) );
}
?>