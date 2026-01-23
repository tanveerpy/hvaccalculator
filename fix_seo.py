import os
import struct
import imghdr
from bs4 import BeautifulSoup

DOMAIN = "https://seer2calc.netlify.app" # Updated to match Screaming Frog screenshot
SEARCH_DIR = "public"

def get_image_size(fname):
    """Determine the image type of fhandle and return its size."""
    try:
        with open(fname, 'rb') as fhandle:
            head = fhandle.read(24)
            if len(head) != 24:
                return None
            if imghdr.what(fname) == 'png':
                check = struct.unpack('>i', head[4:8])[0]
                if check != 0x0d0a1a0a:
                    return None
                width, height = struct.unpack('>ii', head[16:24])
            elif imghdr.what(fname) == 'gif':
                width, height = struct.unpack('<HH', head[6:10])
            elif imghdr.what(fname) == 'jpeg':
                try:
                    fhandle.seek(0)
                    size = 2
                    ftype = 0
                    while not 0xc0 <= ftype <= 0xcf:
                        fhandle.seek(size, 1)
                        byte = fhandle.read(1)
                        while ord(byte) == 0xff:
                            byte = fhandle.read(1)
                        ftype = ord(byte)
                        size = struct.unpack('>H', fhandle.read(2))[0] - 2
                    # We are at a SOFn block
                    fhandle.seek(1, 1)  # Skip `precision' byte.
                    height, width = struct.unpack('>HH', fhandle.read(4))
                except Exception:
                    return None
            else:
                return None
            return width, height
    except Exception:
        return None

def fix_seo(filepath):
    try:
        with open(filepath, "r", encoding="utf-8") as f:
            soup = BeautifulSoup(f, "html.parser")
        
        modified = False
        
        # 1. Fix Canonicals
        head = soup.find("head")
        if head:
            # Remove existing to replace/update
            existing_canonical = head.find("link", {"rel": "canonical"})
            if existing_canonical:
                existing_canonical.decompose()
            
            rel_path = os.path.relpath(filepath, SEARCH_DIR).replace("\\", "/")
            if rel_path == "index.html":
                url = DOMAIN + "/"
            else:
                url = DOMAIN + "/" + rel_path
            
            tag = soup.new_tag("link", rel="canonical", href=url)
            head.append(tag)
            modified = True
            print(f"[Canonical] Updated in {rel_path} to {url}")

        # 2. Fix Meta Descriptions
        if head and not head.find("meta", {"name": "description"}):
            p = soup.find("p")
            if p and p.text.strip():
                desc_text = p.text.strip().replace("\n", " ")[:155] + "..."
                tag = soup.new_tag("meta", attrs={"name": "description", "content": desc_text})
                head.append(tag)
                modified = True
                print(f"[Meta Desc] Added to {os.path.basename(filepath)}")
        
        # 3. Fix Images (Lazy & Dimensions)
        images = soup.find_all("img")
        for i, img in enumerate(images):
            # Alt Text
            if not img.get("alt"):
                img["alt"] = "HVAC illustration"
                modified = True
            
            # Lazy Loading
            if i > 0 and not img.get("loading"):
                img["loading"] = "lazy"
                modified = True
                
            # Dimensions (Width/Height)
            if not img.get("width") or not img.get("height"):
                src = img.get("src")
                if src and not src.startswith("http") and not src.startswith("data:"):
                    # Resolve path relative to the HTML file
                    # HTML file is in 'public/...' or 'public/articles/...'
                    # src might be 'assets/img.jpg' or '../assets/img.jpg'
                    
                    html_dir = os.path.dirname(filepath)
                    img_path = os.path.normpath(os.path.join(html_dir, src))
                    
                    # Check if file exists
                    if os.path.exists(img_path):
                        dims = get_image_size(img_path)
                        if dims:
                            w, h = dims
                            img["width"] = str(w)
                            img["height"] = str(h)
                            modified = True
                            print(f"[Dimensions] Added {w}x{h} to {src}")

        # 4. Fix H1 Hierarchy (Multiple H1s -> H2)
        h1s = soup.find_all("h1")
        if len(h1s) > 1:
            for h1 in h1s[1:]:
                h1.name = "h2"
                h1['class'] = h1.get('class', []) + ['text-3xl']
            modified = True
            print(f"[H1] Fixed multiple H1s in {os.path.basename(filepath)}")

        # 5. Fix Empty Links (Anchor Text)
        links = soup.find_all("a")
        for a in links:
            # Check if it has text or an image with alt, or aria-label
            has_content = (a.get_text(strip=True) or 
                           (a.find("img") and a.find("img").get("alt")) or 
                           a.get("aria-label"))
            
            if not has_content:
                # likely social link or logo without proper label
                href = a.get("href", "")
                if "facebook" in href:
                    a["aria-label"] = "Facebook"
                elif "twitter" in href or "x.com" in href:
                    a["aria-label"] = "Twitter"
                elif "instagram" in href:
                    a["aria-label"] = "Instagram"
                elif "linkedin" in href:
                    a["aria-label"] = "LinkedIn"
                elif href == "index.html":
                    a["aria-label"] = "Home"
                else:
                    a["aria-label"] = "Link"
                modified = True
                print(f"[Anchor] Added aria-label to empty link: {href}")

        if modified:
            with open(filepath, "w", encoding="utf-8") as f:
                f.write(str(soup))

    except Exception as e:
        print(f"Error processing {filepath}: {e}")

def main():
    print(f"Starting SEO Auto-Fixer for {DOMAIN}...")
    for root, dirs, files in os.walk(SEARCH_DIR):
        for file in files:
            if file.endswith(".html"):
                fix_seo(os.path.join(root, file))
    print("Optimization Complete.")

if __name__ == "__main__":
    main()
