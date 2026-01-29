# product_description_popups
Allows a shop owner to include a pop-up image in a product description. It works in the Defines Pages Editor as well and may work any time the included editors are used to create text.
## How We Got Here
Older versions of Zen Cart used a version CKEditolr when setting the product description for a category or product. One of the nicest features was that it allowed the user to turn a link into a popup window. When the user highlighted a particular piece of text and then clicked on the link icon, the Link Info tab allowed the setting of Display Text, Link Type (URL, Link to an anchor in the text, E-Mail, or Phone), Protocol (http://, https://, news://, or <other>), and the URL block to enter what you wanted linked.
The Link Type for a popup was selected as URL, and the Protocol selected as <other>. Then, the URL was entered in the URL field.
Then, when clicking on the Target Tab, the user was provided with options to select the type of Target (<not set>, <frame>, <popup window>,._blank, _top, _self, and _parent). The other fields that appeared were dependent upon the selection of the Target.
For example, if the user selected <popup window>, the Popup Window Name and Popup Window Features fields appeared on the form.
Popup Window Features section of the Target tab contained several options that could be checked or amounts filled in.
Check boxes were:
Resizable
Status Bar
Location Bar
Toolbar
Menu Bar
Full Screen (IE)
Scroll Bars
Dependent (Netscape).
The numerical fields in the Popup Window Features portion of the Target tab were:
Width
Height
Left Position
Top Position

If an owner simply wanted to have an image of a size chart pop up at 420px x 420px, the editor created a link that looked like:

```<a href="/images/large/size_chart.jpg" alt="T-Shirt Size Chart" onclick="window.open(this.href, '', 'resizable=no,status=no,location=no,toolbar=no,menubar=no,fullscreen=no,scrollbars=no,dependent=no,width=420,height=420'); return false;">```

It was used to bring up an image, another site, a PDF, etc. With the evolution of Zen Cart and its current editors (TinyMCE and CKeditor), this feature is no longer available. The storeowner only has the option of _blank or _parent.

## Why the Change?
The use of onclick is now not only out of the editor, but if you are updating from a 1.5.# or earlier version of Zen Cart to a newer version, your onclick code will be stripped from the database entirely.

The code above is sanitized to become.

```<a href="/images/large/CNF-7100-0302E_LRG.jpg" alt="T-Shirt Size Chart">```

By default, attributes like onclick are stripped because they can execute JavaScript, which poses potential XSS risks. This happens during editing and saving, as the editor validates and cleans the HTML. And, experience has shown that editing one product can cause the system to sanitize the entire products_description table.

## What the Mod Does.
By installing the includes/templates/YOUR_TEMPLATE/jscript/jscript_popup.js, you enable a popup method that allows you to change the link to add a class for the popup:

```<a class="image-popup" href="/images/large/CNF-7100-0302E_LRG.jpg" alt="T-Shirt Size Chart">```

When the system sees the new class, the JavaScript file will open a pop-up on the current page. The script is designed to open any size window with the image fully included. It is set to expect 500x500, but if the image is large, it's presented in a smaller version with scroll bars that allow the user to adjust the view as needed. You can adjust settings in the file for the position on the screen.

## How to Install/Use.

Copy the includes/templates/YOUR_TEMPLATE/jscript/jscript_popup.js to your site. Once the file is installed, a pop-up can be initiated by adding the class="image-popup" to the link for the image, page, PDF, etc.

### Examples.

```
<a class="image-popup" href="/images/large/CNF-7100-0302E_LRG.jpg" alt="T-Shirt Size Chart">
<a class="image-popup" href="/documents/t-shirt_catalog.pdf">
<a class="image-popup" href="/index.php?main_page=index&cPath=9_127">
```

## Helpful Notes:
1. **All** links to images require an alt tag to meet accessibility and HTML standards.
2. Adding an alt tag to an anchor or hyperlink (second and third example above) is actually an HTML violation.
3. To avoid confusion with certain operating systems, images should generally start with lowercase, end with the extension in lowercase, and not have any spaces in the filename.

## Was This Mod Helpful?
[Donate to the Zen Cart Project](https://www.zen-cart.com/content.php/6-donate)
