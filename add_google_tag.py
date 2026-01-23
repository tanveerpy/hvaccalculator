
import os

TARGET_DIR = r"c:\HVAC load calc\public"
GOOGLE_TAG = """<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5M1Y2359B0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5M1Y2359B0');
</script>
"""

def add_tag(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    if "G-5M1Y2359B0" in content:
        print(f"Skipping {file_path} (Tag already present)")
        return False

    # Find the <head> tag
    # We look for <head> and try to insert after it.
    # Some files might have attributes in head like <head prefix="..."> so we look for the closing > of the head tag start.
    
    # Simple strategy: Replace <head> with <head>\n{GOOGLE_TAG}
    # This assumes <head> is simple. If it has attributes, we might need regex.
    # Let's check if we can simply find "<head>"
    
    if "<head>" in content:
        new_content = content.replace("<head>", f"<head>\n{GOOGLE_TAG}", 1)
    elif "<head " in content:
        # more complex case, let's try to find the first occurence of <head ... >
        import re
        new_content = re.sub(r'(<head[^>]*>)', r'\1\n' + GOOGLE_TAG, content, count=1, flags=re.IGNORECASE)
    else:
        print(f"Warning: No <head> tag found in {file_path}")
        return False

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    return True

def main():
    modified_count = 0
    for root, dirs, files in os.walk(TARGET_DIR):
        for file in files:
            if file.endswith('.html'):
                file_path = os.path.join(root, file)
                if add_tag(file_path):
                    print(f"Added tag to: {file}")
                    modified_count += 1
    
    print(f"Total files updated: {modified_count}")

if __name__ == "__main__":
    main()
