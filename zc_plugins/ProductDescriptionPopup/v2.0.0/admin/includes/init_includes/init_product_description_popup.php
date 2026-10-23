<?php
/**
 * Product Description Pop-Ups -- puts the editor's wrapper in place.
 *
 * Core's init_html_editor.php (breakpoint 180) leaves the path of the chosen
 * editor's handler in $editor_handler, and every editing page simply includes
 * it. Pointing that variable at this plugin's wrapper is the whole hook: the
 * wrapper includes the original handler and adds the "Open in Pop-Up Window"
 * choice to the editor's link dialog. No core file is touched.
 *
 * Only on the pages whose text appears on the storefront. The same editor is
 * used for order comments, newsletters, gift certificates and admin email,
 * where a pop-up link means nothing, so those are left alone.
 *
 * Only for Zen Cart's own two editors. CKEDITOR is CKEditor 4 on 1.5.8/2.0
 * (whose Target tab still offers a pop-up window, so the wrapper adds nothing
 * there) and CKEditor 5 from 2.1. Any other editor's handler is left as it is.
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$pdpPages = ['product', 'categories', 'define_pages_editor', 'ezpages', 'banner_manager'];
$pdpEditor = isset($_SESSION['html_editor_preference_status']) ? (string)$_SESSION['html_editor_preference_status'] : '';

if (!empty($editor_handler)
    && !defined('PRODUCT_DESCRIPTION_POPUP_EDITOR_HANDLER')
    && in_array($pdpEditor, ['CKEDITOR', 'TINYMCE'], true)
    && in_array(basename($PHP_SELF, '.php'), $pdpPages, true)
) {
    define('PRODUCT_DESCRIPTION_POPUP_EDITOR_HANDLER', $editor_handler);
    $editor_handler = dirname(__DIR__) . '/product_description_popup_editor.php';
}
unset($pdpPages, $pdpEditor);
