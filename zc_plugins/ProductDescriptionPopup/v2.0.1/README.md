# Product Description Pop-Ups

Version 2.0.1 · Zen Cart 1.5.8 through 3.0.0 · PHP 7.4 through 8.5 · GPL v3 · by My Zen Cart Host (dbltoe)

Brings back the editor's "open this link in a pop-up window" choice that went away with CKEditor 4, for the links you pick.

## Why it exists

Zen Cart 1.5.8 and 2.0 use CKEditor 4. In its link dialog, the **Target** tab offers `<popup window>`, with a size and position. A store owner could make one link, say a size chart in a T-shirt's description, open in a small window beside the product page.

Zen Cart 2.1 moved to CKEditor 5, and 2.2 made TinyMCE the default editor. Neither has that choice. Both also strip the `onclick` code that CKEditor 4 wrote, the next time that description is saved in them, so the old pop-up links turn into ordinary links. CKEditor 5 also strips any `class` you type on a link.

This plugin puts the choice back.

## What it does

**In the admin:** adds **Open in Pop-Up Window** to the link dialog of CKEditor 5 and TinyMCE, on the product, category, define page, EZ-Page and banner editors. Choosing it gives that one link `class="image-popup"`, and both editors keep it.

**On the storefront:** when a shopper clicks a link marked that way:

- an image (`.jpg`, `.png`, `.webp` and so on) opens in a window sized to the picture, up to 85% of the screen, on a dark background, toward the right of the screen. `Esc` closes it;
- anything else, such as a PDF or another page, opens in the window as it is.

Every other link is left alone. Ctrl-, Cmd-, Shift- and middle-clicks still do what the browser normally does. If the browser blocks the window, the link opens like an ordinary link.

No core files are changed, and there's nothing to configure.

## Installing

1. Upload the `zc_plugins/ProductDescriptionPopup` folder to your store's `zc_plugins/` folder.
2. In the admin, go to **Modules > Plugin Manager**, select **Product Description Pop-Ups** and click **Install**.

That's all. There are no settings and no database tables.

Once it's installed, a superuser can open this guide from the **ReadMe** button in Plugin Manager.

## Upgrading from v2.0.0

Upload the `v2.0.1` folder beside the old one in `zc_plugins/ProductDescriptionPopup` and click **Upgrade** in **Modules > Plugin Manager**. Links you already marked keep working.

## Upgrading from v1

Version 1 was a single file, `includes/templates/YOUR_TEMPLATE/jscript/jscript_popup.js`. **Delete that file** from every template you copied it into, then install this plugin.

Leaving it in place does no harm (the two never open two windows for one click), but the old file's handling wins on the links it sees, and it can't open PDFs or pages.

Links you already marked with `class="image-popup"` keep working without any change.

## Marking a link

| Editor | What to do |
| --- | --- |
| CKEditor 5 (Zen Cart 2.1+) | Select the text, click the link button, enter the address, and turn on the **Open in Pop-Up Window** switch. |
| TinyMCE (Zen Cart 2.2+) | Select the text, click the link button, enter the address, and choose **Open in Pop-Up Window** from the **Class** list. |
| CKEditor 4 (Zen Cart 1.5.8, 2.0) | Use the link dialog's **Target** tab and choose `<popup window>`, as before. Those links open on their own; this plugin doesn't need to do anything for them. |
| Plain text | Type the class on the link yourself, as shown below. |

```
<a class="image-popup" href="/images/large/size_chart.jpg">Size chart</a>
<a class="image-popup" href="/documents/t-shirt_catalog.pdf">Catalog (PDF)</a>
<a class="image-popup" href="/index.php?main_page=index&amp;cPath=9_127">More shirts</a>
```

> The image's alt text and the window's title come from the link: its `title`, the alt text of an image inside the link, or the link's own words. Give links meaningful text.

## Changing where the window opens

The window opens 40 pixels from the right edge of the screen and 100 pixels from the top. To change that, copy

```
zc_plugins/ProductDescriptionPopup/v2.0.1/catalog/includes/templates/default/jscript/product_description_popup.js
```

into your template's `includes/templates/YOUR_TEMPLATE/jscript/` folder and edit the settings at the top of your copy. The plugin uses your copy when there is one. Keep the file name.

> When you install a later version of the plugin, compare your copy with the new one; your copy is used in its place.

## Compatibility

- Zen Cart 1.5.8 through 3.0.0; PHP 7.4 through 8.5.
- Any storefront template, including ZCA Bootstrap.
- Editors: Zen Cart's own CKEditor (4 or 5) and TinyMCE. Another editor plugin is left alone; mark links in it with the class by hand.
- Your own `editors/ckeditor5/config.js` or `editors/tinymce/config.js` settings are kept. If you've set your own link decorators or Class list, the pop-up choice is added to them.
- Current browsers. Not Internet Explorer.
- On phones and tablets, browsers open the "window" as a new tab.

## Helpful notes

1. Every image on your pages needs an `alt` attribute. A link (`<a>`) doesn't take one; use `title` or clear link text instead.
2. Image file names are safest in lowercase, with a lowercase extension and no spaces.

## Uninstalling

In **Modules > Plugin Manager**, select the plugin and click **Uninstall**. Your descriptions are untouched; links you marked simply become ordinary links again until the plugin is reinstalled.

## Support

Ask in the Zen Cart forum support thread (https://www.zen-cart.com/threads/207083?page=1#post-1344943), or open an issue on GitHub (https://github.com/dbltoe/product_description_popups).

Was this plugin helpful? Donate to the Zen Cart Project (https://www.zen-cart.com/content.php/6-donate).

## Changelog

See `CHANGELOG.md`. Version 2.0.1 moves the plugin to the GNU General Public License, version 3, and replaces readme.html with this guide, opened from the ReadMe button in Plugin Manager.

## License

Product Description Pop-Ups is free software under the GNU General Public License, version 3 (https://www.gnu.org/licenses/gpl-3.0.html); the full text is in `LICENSE`. Copyright © 2026 My Zen Cart Host (dbltoe).
