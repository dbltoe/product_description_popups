<?php
/**
 * Product Description Pop-Ups -- storefront observer.
 *
 * Links the pop-up script on every storefront page, since a marked link can be
 * in a product or category description, a define page, an EZ-Page or a banner.
 * The script is small and deferred, and does nothing until a marked link is
 * clicked.
 *
 * Loaded by core's init_observers.php, which instantiates zcObserver + the
 * camelized file name; it must not also be listed in an auto-loader.
 * NOTIFY_HTML_HEAD_END fires at the end of html_header.php on every release
 * from 1.5.8 to 3.0.0.
 *
 * The script is deliberately not named jscript_*.js: Zen Cart 3.0.0 can pick up
 * a plugin's jscript_*.js on its own, and it would then load twice.
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

class zcObserverProductDescriptionPopup extends base
{
    /** @var string */
    protected $scriptName = 'product_description_popup.js';

    /** @var string This version's catalog directory, relative to the store root. */
    protected $catalogPath;

    public function __construct()
    {
        $versionDir = dirname(__DIR__, 4);
        $this->catalogPath = 'zc_plugins/' . basename(dirname($versionDir)) . '/' . basename($versionDir) . '/catalog/';

        $this->attach($this, ['NOTIFY_HTML_HEAD_END']);
    }

    public function updateNotifyHtmlHeadEnd(&$class, $eventID, $current_page_base)
    {
        echo '<script src="' . $this->scriptUrl((string)$current_page_base) . '" defer></script>' . "\n";
    }

    /**
     * The store's own copy when its template has one (so the position settings
     * at the top of the script can be changed without editing the plugin),
     * otherwise the plugin's. get_template_dir() looks in the active template
     * first on every release.
     */
    protected function scriptUrl(string $current_page_base): string
    {
        global $template;
        if (is_object($template)) {
            $dir = rtrim($template->get_template_dir($this->scriptName, DIR_WS_TEMPLATE, $current_page_base, 'jscript'), '/') . '/';
            if (file_exists($dir . $this->scriptName)) {
                return $dir . $this->scriptName;
            }
        }
        return $this->catalogPath . 'includes/templates/default/jscript/' . $this->scriptName;
    }
}
