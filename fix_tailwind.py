import os

def fix_tailwind_cdn(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.lower().endswith('.html') or file.lower().endswith('.php'):
                filepath = os.path.join(root, file)
                try:
                    with open(filepath, 'r', encoding='utf-8') as f:
                        content = f.read()
                    
                    # specific replacement string
                    old_script = '<script src="https://cdn.tailwindcss.com"></script>'
                    new_script = '<script src="https://cdn.tailwindcss.com?plugins=typography"></script>'
                    
                    if old_script in content:
                        content = content.replace(old_script, new_script)
                        with open(filepath, 'w', encoding='utf-8') as f:
                            f.write(content)
                        print(f"Updated Tailwind CDN in {file}")
                        
                except Exception as e:
                    print(f"Error processing {file}: {e}")

if __name__ == "__main__":
    fix_tailwind_cdn(r'c:\HVAC load calc\public')
