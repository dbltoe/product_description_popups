# Product Description Pop-Ups

Brings back the editor's "open this link in a pop-up window" choice that went away with CKEditor 4, for the links you pick.

Version 2.0.0 · Zen Cart 1.5.8 - 3.0.0 · PHP 7.4 - 8.5 · GPL-2.0 · by My Zen Cart Host (dbltoe)

## Why It Exists

Zen Cart 1.5.8 and 2.0 use CKEditor 4. Its link dialog's **Target** tab offers *&lt;popup window&gt;*, so one link, say a size chart in a T-shirt's description, could open in a small window beside the product page.

Zen Cart 2.1 moved to CKEditor 5, and 2.2 made TinyMCE the default editor. Neither has that choice, and both strip the `onclick` code CKEditor 4 wrote the next time that description is saved in them. CKEditor 5 also strips any `class` typed on a link.

## What It Does

- **Admin:** adds **Open in Pop-Up Window** to the CKEditor 5 and TinyMCE link dialogs on the product, category, define page, EZ-Page and banner editors. Choosing it gives that one link `class="image-popup"`, which both editors keep.
- **Storefront:** a click on a marked link opens a small window. An image opens sized to the picture (up to 85% of the screen); a PDF or page opens as it is. Every other link is left alone.
- No core files are changed, and there's nothing to configure.

## Installing

1. Upload `zc_plugins/ProductDescriptionPopup` to your store's `zc_plugins/` folder.
2. In **Modules > Plugin Manager**, select **Product Description Pop-Ups** and click **Install**.

**Upgrading from v1:** delete `includes/templates/YOUR_TEMPLATE/jscript/jscript_popup.js` from every template you copied it into. Links already marked with `class="image-popup"` keep working.

## Marking a Link

| Editor | What to do |
|---|---|
| CKEditor 5 (Zen Cart 2.1+) | In the link box, turn on **Open in Pop-Up Window**. |
| TinyMCE (Zen Cart 2.2+) | In the link dialog, choose **Open in Pop-Up Window** from the **Class** list. |
| CKEditor 4 (1.5.8, 2.0) | Use the **Target** tab's *&lt;popup window&gt;*, as before. |
| Plain text | Type it yourself: `<a class="image-popup" href="/images/large/size_chart.jpg">Size chart</a>` |

The full guide, including how to change where the window opens, is in `readme.html` (also in Plugin Manager's **Read Me** button).

## Support

[Zen Cart forum support thread](https://www.zen-cart.com/showthread.php/231009-Support-Thread-for-Product-Description-Pop-Ups?p=1410429#post1410429) · [GitHub issues](https://github.com/dbltoe/product_description_popups/issues)

Was this plugin helpful? [Donate to the Zen Cart Project](https://www.zen-cart.com/content.php/6-donate)
