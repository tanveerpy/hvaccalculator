import os
from bs4 import BeautifulSoup

DOMAIN = "https://hvac-manual-j-calculator.netlify.app"
SEARCH_DIR = "public"

def fix_seo(filepath):
    try:
        with open(filepath, "r", encoding="utf-8") as f:
            soup = BeautifulSoup(f, "html.parser")
        
        modified = False
        
        # 1. Fix Canonicals
        head = soup.find("head")
        if head and not head.find("link", {"rel": "canonical"}):
            rel_path = os.path.relpath(filepath, SEARCH_DIR).replace("\\", "/")
            if rel_path == "index.html":
                url = DOMAIN + "/"
            else:
                url = DOMAIN + "/" + rel_path
            
            tag = soup.new_tag("link", rel="canonical", href=url)
            head.append(tag)
            modified = True
            print(f"[Canonical] Added to {rel_path}")

        # 2. Fix Meta Descriptions
        if head and not head.find("meta", {"name": "description"}):
            # Try to grab first paragraph
            p = soup.find("p")
            if p and p.text.strip():
                desc_text = p.text.strip().replace("\n", " ")[:155] + "..."
                tag = soup.new_tag("meta", attrs={"name": "description", "content": desc_text})
                head.append(tag)
                modified = True
                print(f"[Meta Desc] Added to {os.path.basename(filepath)}")
        
        # 3. Fix Images (Lazy & Dimensions)
        # Note: We can't easily guess dimensions without opening images, 
        # but we can add loading="lazy" to all non-hero images.
        images = soup.find_all("img")
        for i, img in enumerate(images):
            # correct missing alt
            if not img.get("alt"):
                img["alt"] = "HVAC illustration" # Generic fallback
                modified = True
            
            # Lazy load everything except the very first image (usually hero/logo)
            if i > 0 and not img.get("loading"):
                img["loading"] = "lazy"
                modified = True

        # 4. Fix H1 Hierarchy (Multiple H1s -> H2)
        h1s = soup.find_all("h1")
        if len(h1s) > 1:
            for h1 in h1s[1:]:
                h1.name = "h2"
                h1['class'] = h1.get('class', []) + ['text-3xl'] # Maintain some size
            modified = True
            print(f"[H1] Fixed multiple H1s in {os.path.basename(filepath)}")

        if modified:
            with open(filepath, "w", encoding="utf-8") as f:
                f.write(str(soup))

    except Exception as e:
        print(f"Error processing {filepath}: {e}")

def main():
    print("Starting SEO Auto-Fixer...")
    for root, dirs, files in os.walk(SEARCH_DIR):
        for file in files:
            if file.endswith(".html"):
                fix_seo(os.path.join(root, file))
    print("Optimization Complete.")

if __name__ == "__main__":
    main()
