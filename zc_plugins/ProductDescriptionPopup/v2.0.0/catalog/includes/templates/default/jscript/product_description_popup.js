/**
 * Product Description Pop-Ups v2.0.0
 *
 * Opens a link in a small pop-up window when the store owner has marked that
 * one link with class="image-popup" -- the editor's "Open in Pop-Up Window"
 * choice, which this plugin adds to the CKEditor 5 and TinyMCE link dialogs.
 * Every other link is left alone.
 *
 *   - An image (.jpg, .png, .webp ...) opens in a window sized to the picture,
 *     up to 85% of the screen, on a dark background.
 *   - Anything else (a PDF, another page) opens in the window as it is.
 *   - Ctrl/Cmd/Shift/Alt-click and middle-click still do what the browser does.
 *   - If the browser blocks the window, the link opens as an ordinary link.
 *   - Old CKEditor 4 links that still carry their own onclick keep working:
 *     they handle the click themselves first, and this script stands aside.
 *
 * To change where the window opens, copy this file into your template's
 * jscript folder (includes/templates/YOUR_TEMPLATE/jscript/) and edit the
 * settings below; the plugin then uses your copy.
 *
 * @package  ProductDescriptionPopup
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GNU General Public License v2.0
 */
(function () {
    'use strict';

    // ---- Settings -----------------------------------------------------------
    var RIGHT_OFFSET = 40;     // pixels between the window and the right edge of the screen
    var TOP_POSITION = 100;    // pixels from the top of the screen
    var IMAGE_START = 500;     // window size while an image loads; it is then resized to fit
    var PAGE_WIDTH = 900;      // window size for a PDF or a page
    var PAGE_HEIGHT = 700;
    var MAX_SHARE = 0.85;      // never larger than this share of the screen
    // -------------------------------------------------------------------------

    var POPUP_CLASS = 'image-popup';
    var IMAGE_PATH = /\.(?:avif|bmp|gif|jpe?g|png|svg|webp)$/i;

    // Loaded twice (a template copy as well as the plugin's): bind once.
    if (window.productDescriptionPopupLoaded) {
        return;
    }
    window.productDescriptionPopupLoaded = true;

    function screenArea() {
        return {
            left: screen.availLeft || 0,
            top: screen.availTop || 0,
            width: screen.availWidth || screen.width,
            height: screen.availHeight || screen.height
        };
    }

    function fitToScreen(width, height) {
        var area = screenArea();
        return {
            width: Math.round(Math.min(width, area.width * MAX_SHARE)),
            height: Math.round(Math.min(height, area.height * MAX_SHARE))
        };
    }

    // Right-hand side of the screen the shopper is using, as before.
    function position(width) {
        var area = screenArea();
        return {
            left: Math.max(area.left, area.left + area.width - width - RIGHT_OFFSET),
            top: area.top + TOP_POSITION
        };
    }

    function features(width, height) {
        var size = fitToScreen(width, height);
        var at = position(size.width);
        return 'popup=yes,resizable=yes,scrollbars=yes,width=' + size.width + ',height=' + size.height
            + ',left=' + at.left + ',top=' + at.top;
    }

    // Text for the image's alt and the window title: the link's title, the
    // alt of an image inside the link, or the link's own text.
    function describe(link) {
        var inner = link.querySelector('img[alt]');
        var text = link.getAttribute('title') || (inner ? inner.getAttribute('alt') : '') || link.textContent || '';
        return text.replace(/\s+/g, ' ').trim();
    }

    function openImage(link, url) {
        var popup = window.open('', '_blank', features(IMAGE_START, IMAGE_START));
        if (!popup) {
            return false;
        }

        // Built with DOM calls rather than written out as HTML text, so nothing
        // in the URL can become markup and a Content-Security-Policy has no
        // inline script to object to.
        var doc = popup.document;
        var label = describe(link);
        doc.title = label || link.pathname.split('/').pop();
        if (document.documentElement.lang) {
            doc.documentElement.lang = document.documentElement.lang;
        }

        var body = doc.body || doc.documentElement.appendChild(doc.createElement('body'));
        while (body.firstChild) {
            body.removeChild(body.firstChild);
        }
        body.style.margin = '0';
        body.style.padding = '30px';
        body.style.background = '#111';
        body.style.display = 'flex';
        body.style.justifyContent = 'center';
        body.style.alignItems = 'center';
        body.style.minHeight = '100vh';
        body.style.boxSizing = 'border-box';

        var img = doc.createElement('img');
        img.alt = label;
        img.style.maxWidth = '100%';
        img.style.maxHeight = 'calc(100vh - 60px)';
        img.style.objectFit = 'contain';
        img.style.border = '1px solid #fff';
        img.addEventListener('load', function () {
            var size = fitToScreen(img.naturalWidth + 80, img.naturalHeight + 120);
            var at = position(size.width);
            try {
                popup.resizeTo(size.width, size.height);
                popup.moveTo(at.left, at.top);
            } catch (e) {
                // A browser may refuse to move or resize; the image still shows.
            }
        });
        img.src = url;
        body.appendChild(img);

        doc.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                popup.close();
            }
        });
        popup.focus();
        return true;
    }

    function openPage(url) {
        var popup = window.open(url, '_blank', features(PAGE_WIDTH, PAGE_HEIGHT));
        if (!popup) {
            return false;
        }
        try {
            popup.opener = null;
        } catch (e) {
            // Nothing to do; the window is open.
        }
        return true;
    }

    // One listener on the document, so links that arrive after the page has
    // loaded (tabs, quick views) work too.
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) {
            return;
        }
        var link = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (!link || !link.classList.contains(POPUP_CLASS) || !/^https?:$/.test(link.protocol)) {
            return;
        }

        e.preventDefault();
        var url = link.href;
        var opened = IMAGE_PATH.test(link.pathname) ? openImage(link, url) : openPage(url);
        if (!opened) {
            window.location.href = url;
        }
    });
})();
