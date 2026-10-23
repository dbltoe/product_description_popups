<?php
/**
 * Product Description Pop-Ups -- plugin manifest.
 *
 * pluginDescription is echoed into Plugin Manager's info box as raw HTML on
 * every release from 1.5.8 to 3.0.0. On 1.5.8, 2.0 and 2.1 it is stored only
 * when Plugin Manager first sees the plugin, so the links below must be right
 * from the first release.
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
$pdpPluginDir = 'zc_plugins/ProductDescriptionPopup/v2.0.0/';
$pdpReadmeUrl = (defined('DIR_WS_CATALOG') ? DIR_WS_CATALOG : '/') . $pdpPluginDir . 'readme.html';
$pdpGithubUrl = 'https://github.com/dbltoe/product_description_popups';
// Permalink to the support thread's opening post.
$pdpForumUrl = 'https://www.zen-cart.com/showthread.php/231009-Support-Thread-for-Product-Description-Pop-Ups?p=1410429#post1410429';

$pdpButtonGap = '6px';
$pdpLinks =
    '<div style="margin:10px 0 0;padding:0 0 0 ' . $pdpButtonGap . '">'
    . '<a href="' . $pdpReadmeUrl . '" target="_blank" rel="noopener noreferrer"'
    . ' class="btn btn-primary" role="button"'
    . ' style="margin:0 ' . $pdpButtonGap . ' 0 0">Read Me</a>'
    . '<a href="' . $pdpGithubUrl . '" target="_blank" rel="noopener noreferrer"'
    . ' class="btn btn-primary" role="button"'
    . ' style="margin:0 ' . $pdpButtonGap . ' 0 0">GitHub</a>'
    . ($pdpForumUrl !== ''
        ? '<a href="' . $pdpForumUrl . '" target="_blank" rel="noopener noreferrer"'
          . ' class="btn btn-primary" role="button"'
          . ' style="margin:0 ' . $pdpButtonGap . ' 0 0">Forum Support Thread</a>'
        : '')
    . '</div>';

return [
    'pluginVersion' => 'v2.0.0',
    'pluginName' => 'Product Description Pop-Ups',
    'pluginDescription' =>
        'Brings back the editor\'s "open this link in a pop-up window" choice that went away with CKEditor 4. '
        . 'Pick it for any single link in a product or category description, a define page, an EZ-Page or a banner, '
        . 'and that link opens a small window on the storefront: an image sized to fit, or a PDF or page as it is. '
        . 'Adds an "Open in Pop-Up Window" choice to the CKEditor 5 and TinyMCE link dialogs; no core files are changed.'
        . $pdpLinks,
    // plugin_control.author is varchar(64).
    'pluginAuthor' => 'My Zen Cart Host (dbltoe)',
    // Not in the Zen Cart Plugins Library yet; set to its ID once the listing is accepted.
    'pluginId' => 0,
    'zcVersions' => ['v158', 'v200', 'v210', 'v220', 'v230', 'v300'],
    'changelog' => 'changelog.txt',
    'github_repo' => $pdpGithubUrl,
    'pluginGroups' => [],
];
