import os
import re
from PIL import Image

def optimize_and_convert(directory, html_dir):
    # Track optimized images map: old_filename -> (new_filename, width, height)
    image_map = {}

    # 1. Optimize and Convert Images
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.lower().endswith(('.png', '.jpg', '.jpeg')) and not file.lower().endswith('.webp'):
                filepath = os.path.join(root, file)
                try:
                    with Image.open(filepath) as img:
                        # Resize
                        width, height = img.size
                        if width > 1200:
                            new_width = 1200
                            new_height = int((new_width / width) * height)
                            img = img.resize((new_width, new_height), Image.Resampling.LANCZOS)
                        else:
                            new_width, new_height = width, height

                        # Save as WebP
                        new_filename = os.path.splitext(file)[0] + '.webp'
                        new_filepath = os.path.join(root, new_filename)
                        img.save(new_filepath, 'WEBP', quality=80)
                        
                        file_size = os.path.getsize(filepath)
                        new_size = os.path.getsize(new_filepath)
                        print(f"Converted {file} ({file_size/1024:.2f}KB) to {new_filename} ({new_size/1024:.2f}KB)")
                        
                        # Store info for HTML update
                        # Relative path from 'public/' is needed.
                        # Assuming directory is 'public/assets/images' or 'public/assets/img'
                        # references in HTML are usually 'assets/images/...' or '../assets/images/...'
                        
                        image_map[file] = {
                            'new_name': new_filename,
                            'width': new_width,
                            'height': new_height
                        }

                except Exception as e:
                    print(f"Error processing {file}: {e}")

    # 2. Update HTML Files
    for root, dirs, files in os.walk(html_dir):
        for file in files:
            if file.lower().endswith('.html') or file.lower().endswith('.php'):
                filepath = os.path.join(root, file)
                try:
                    with open(filepath, 'r', encoding='utf-8') as f:
                        content = f.read()
                    
                    original_content = content
                    
                    for old_name, info in image_map.items():
                        new_name = info['new_name']
                        w = info['width']
                        h = info['height']
                        
                        # Regex to find <img> tags using this file
                        # Looking for src=".../old_name"
                        # We want to replace the extension and add width/height if missing
                        
                        # Simple replacement of filename first (risky if filename is common, but these look specific)
                        # Better: Find the img tag and update it.
                        
                        # Find tags like <img ... src="...old_name..." ...>
                        # Use regex substitute with callback
                        
                        def replace_callback(match):
                            img_tag = match.group(0)
                            if 'width=' in img_tag and 'height=' in img_tag:
                                # Just replace extension
                                return img_tag.replace(old_name, new_name)
                            else:
                                # Replace extension AND add width/height
                                new_tag = img_tag.replace(old_name, new_name)
                                # Add attributes before the closing >
                                # Check if class exists to avoid messing up
                                insert_pos = new_tag.rfind('>')
                                if new_tag.endswith('/>'):
                                     insert_pos = new_tag.rfind('/>')
                                
                                attrs = f' width="{w}" height="{h}"'
                                return new_tag[:insert_pos] + attrs + new_tag[insert_pos:]

                        # Regex for img tag containing the filename
                        pattern = re.compile(f'<img[^>]*src=["\'][^"\']*{re.escape(old_name)}["\'][^>]*>', re.IGNORECASE)
                        content = pattern.sub(replace_callback, content)

                    if content != original_content:
                        with open(filepath, 'w', encoding='utf-8') as f:
                            f.write(content)
                        print(f"Updated references in {file}")

                except Exception as e:
                    print(f"Error updating {file}: {e}")

if __name__ == "__main__":
    assets_dirs = [r'c:\HVAC load calc\public\assets\images', r'c:\HVAC load calc\public\assets\img']
    html_dir = r'c:\HVAC load calc\public'
    
    for d in assets_dirs:
       optimize_and_convert(d, html_dir)
