<?php
/**
 * Product Description Pop-Ups -- admin auto-loader.
 *
 * Breakpoint 181 runs straight after core's init_html_editor.php (180), which
 * is where $editor_handler, the editor every editing page includes, is chosen.
 * Same breakpoint on every release from 1.5.8 to 3.0.0.
 *
 * Only an init_script is listed here. The plugin has no admin observer, and an
 * observer must never be listed in an auto-loader anyway (init_observers.php
 * already loads auto.*.php files, and a second load is a redeclare fatal).
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$autoLoadConfig[181][] = [
    'autoType' => 'init_script',
    'loadFile' => 'init_product_description_popup.php',
];
