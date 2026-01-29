document.addEventListener('DOMContentLoaded', function() {
  const popupLinks = document.querySelectorAll('a.image-popup');
  popupLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const url = this.href;

      // Desired popup size (will be adjusted dynamically later)
      const desiredWidth = 500;   // Starting guess; resize will override
      const desiredHeight = 500;

      // Calculate right-side position (adjust offset as needed)
      const rightOffset = 40;  // Pixels from right edge (increase if too close to edge)
      const leftPos = screen.width - desiredWidth - rightOffset;
      const topPos = 100;      // From top (adjust: 0 = top edge, higher = lower down)

      // Open with position in features string (better initial placement)
      const features = `resizable=yes,scrollbars=yes,status=no,location=no,toolbar=no,menubar=no,width=${desiredWidth},height=${desiredHeight},left=${leftPos},top=${topPos}`;
      const popup = window.open('', '_blank', features);

      if (!popup || popup.closed || typeof popup.closed === 'undefined') {
        alert('Popup blocked! Allow popups for this site.');
        return;
      }

      popup.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <title>Image Preview</title>
          <style>
            body {
              margin: 0;
              padding: 30px;
              background: #111;
              display: flex;
              justify-content: center;
              align-items: center;
              min-height: 100vh;
              box-sizing: border-box;
            }
            img {
              max-width: 100%;
              max-height: calc(100vh - 60px);
              object-fit: contain;
              border: 1px solid #fff;
            }
          </style>
        </head>
        <body>
          <img id="previewImg" src="${url}" alt="Product Image">
          <script>
            const img = document.getElementById('previewImg');
            function resizeAndPosition() {
              if (!img.naturalWidth || !img.naturalHeight) return;
              const bufferH = 80;
              const bufferV = 120;  // Vertical buffer for chrome/title bar
              let w = img.naturalWidth + bufferH;
              let h = img.naturalHeight + bufferV;
              const maxW = screen.availWidth * 0.85;
              const maxH = screen.availHeight * 0.85;
              w = Math.min(w, maxW);
              h = Math.min(h, maxH);

              // Resize first
              window.resizeTo(w, h);

              // Then reposition to right side (recalculate left based on final width)
              const rightOffset = 40;
              const newLeft = screen.width - w - rightOffset;
              const topPos = 100;  // Or Math.max(0, (screen.availHeight - h) / 4) for slight top offset
              window.moveTo(newLeft, topPos);
            }

            if (img.complete) {
              resizeAndPosition();
            } else {
              img.onload = resizeAndPosition;
            }
            // Fallback timing
            setTimeout(resizeAndPosition, 500);
          </script>
        </body>
        </html>
      `);
      popup.document.close();
    });
  });
});