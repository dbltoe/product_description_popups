<?php
/**
 * Product Description Pop-Ups -- the editor wrapper.
 *
 * Included by the editing page in place of the editor's own handler (see
 * init_includes/init_product_description_popup.php). It includes that handler
 * unchanged, then slips one small script in front of the editor's start-up
 * script, so the editor is created with an "Open in Pop-Up Window" choice in
 * its link dialog. A link given that choice gets class="image-popup", which is
 * what the storefront script acts on.
 *
 * Why in front of the start-up script: both editors read a settings object that
 * the store's own editors/<editor>/config.js declares (myCKEditorConfig,
 * myTinyMceConfig) and merge it over core's settings when they start. Adding to
 * that object after config.js has run and before the editor starts is the one
 * moment it can be done without editing either file. The start-up scripts are
 * found by their title attributes, which are the same in 2.1, 2.2, 2.3 and
 * 3.0.0. If one is not found, the handler's output goes out untouched: the
 * choice is missing, and nothing else changes.
 *
 * CKEditor 4 (1.5.8, 2.0) has no such start-up script, and needs nothing: its
 * link dialog still has the Target tab's "<popup window>".
 *
 * Runs in the scope of the page that included it, so its own variables are
 * prefixed and removed afterwards.
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

ob_start();
include PRODUCT_DESCRIPTION_POPUP_EDITOR_HANDLER;
$pdpOutput = (string)ob_get_clean();

$pdpLabel = defined('PRODUCT_DESCRIPTION_POPUP_EDITOR_OPTION') ? PRODUCT_DESCRIPTION_POPUP_EDITOR_OPTION : 'Open in Pop-Up Window';
$pdpNone = defined('PRODUCT_DESCRIPTION_POPUP_EDITOR_NO_CLASS') ? PRODUCT_DESCRIPTION_POPUP_EDITOR_NO_CLASS : 'None';
$pdpJson = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;

// Not strict mode, on purpose: assigning to myCKEditorConfig / myTinyMceConfig
// must reach the `let` that config.js declares, or create the global when the
// store has removed config.js. Strict mode would throw on the second case.
$pdpScripts = [
    // CKEditor 5 (2.1+). A manual link decorator is an on/off switch in the
    // link box. The store's `link` settings replace core's whole `link` block,
    // so when the store has none, core's own (identical in 2.1 - 3.0.0) are
    // repeated here or "Open in a new tab" would disappear.
    '<script title="CKEditor-initialize"' =>
        '(function () {' . "\n"
        . '    if (typeof myCKEditorConfig !== "object" || myCKEditorConfig === null) { myCKEditorConfig = {}; }' . "\n"
        . '    var link = myCKEditorConfig.link || {' . "\n"
        . '        defaultProtocol: "https://",' . "\n"
        . '        allowedProtocols: ["https?", "tel", "sms", "mailto"],' . "\n"
        . '        decorators: {openInNewTab: {mode: "manual", label: "Open in a new tab", attributes: {target: "_blank", rel: "noopener noreferrer"}}}' . "\n"
        . '    };' . "\n"
        . '    link.decorators = link.decorators || {};' . "\n"
        . '    var have = Object.keys(link.decorators).some(function (k) { return String(link.decorators[k].classes || "").split(/\s+/).indexOf("image-popup") !== -1; });' . "\n"
        . '    if (!have) { link.decorators.productDescriptionPopup = {mode: "manual", label: ' . json_encode($pdpLabel, $pdpJson) . ', classes: "image-popup"}; }' . "\n"
        . '    myCKEditorConfig.link = link;' . "\n"
        . '})();',
    // TinyMCE (2.2+). link_class_list adds a Class list to the link dialog.
    '<script title="TinyMCE-initialize"' =>
        '(function () {' . "\n"
        . '    if (typeof myTinyMceConfig !== "object" || myTinyMceConfig === null) { myTinyMceConfig = {}; }' . "\n"
        . '    var list = Array.isArray(myTinyMceConfig.link_class_list) ? myTinyMceConfig.link_class_list : [{title: ' . json_encode($pdpNone, $pdpJson) . ', value: ""}];' . "\n"
        . '    var have = list.some(function (item) { return item && item.value === "image-popup"; });' . "\n"
        . '    if (!have) { list.push({title: ' . json_encode($pdpLabel, $pdpJson) . ', value: "image-popup"}); }' . "\n"
        . '    myTinyMceConfig.link_class_list = list;' . "\n"
        . '})();',
];

foreach ($pdpScripts as $pdpAnchor => $pdpScript) {
    $pdpAt = strpos($pdpOutput, $pdpAnchor);
    if ($pdpAt !== false) {
        $pdpOutput = substr($pdpOutput, 0, $pdpAt)
            . '<script title="ProductDescriptionPopup-link-option">' . "\n" . $pdpScript . "\n" . '</script>' . "\n"
            . substr($pdpOutput, $pdpAt);
        break;
    }
}

echo $pdpOutput;
unset($pdpOutput, $pdpLabel, $pdpNone, $pdpJson, $pdpScripts, $pdpAnchor, $pdpScript, $pdpAt);
