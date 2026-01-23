
import os

TARGET_DIR = r"c:\HVAC load calc\public"

def fix_links(content, file_depth):
    # If file is at root (depth 0), we replace "index.html" with "/"
    if file_depth == 0:
        content = content.replace('href="index.html"', 'href="/"')
        content = content.replace('href="./index.html"', 'href="/"')
    else:
        # If file is in subfolder (e.g. articles/), we replace "../index.html" with "/"
        content = content.replace('href="../index.html"', 'href="/"')
        content = content.replace('href="../../index.html"', 'href="/"') # Just in case

    return content

def main():
    modified_count = 0
    # Root files
    for file in os.listdir(TARGET_DIR):
        if file.endswith('.html'):
            file_path = os.path.join(TARGET_DIR, file)
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            new_content = fix_links(content, 0)
            
            if new_content != content:
                print(f"Fixing root file: {file}")
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                modified_count += 1

    # Subdirectories (articles)
    for root, dirs, files in os.walk(TARGET_DIR):
        if root == TARGET_DIR: continue # Skip root as we handled it
        
        rel_path = os.path.relpath(root, TARGET_DIR)
        depth = len(rel_path.split(os.sep))
        
        for file in files:
            if file.endswith('.html'):
                file_path = os.path.join(root, file)
                with open(file_path, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                new_content = fix_links(content, depth)
                
                if new_content != content:
                    print(f"Fixing sub file: {rel_path}\{file}")
                    with open(file_path, 'w', encoding='utf-8') as f:
                        f.write(new_content)
                    modified_count += 1

    print(f"Total files updated: {modified_count}")

if __name__ == "__main__":
    main()
