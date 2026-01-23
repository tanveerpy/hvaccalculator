
import os

TARGET_DIR = r"c:\HVAC load calc\public"
OLD_DOMAINS = [
    "writeoffcalc.com",
    "hvac-manual-j-calculator.netlify.app"
]
NEW_DOMAIN = "seer2calculator.com"
PROTOCOL = "https://"

def fix_content(content):
    original_content = content
    # Handle both http and https, though we mostly see https
    for domain in OLD_DOMAINS:
        content = content.replace(f"https://{domain}", f"{PROTOCOL}{NEW_DOMAIN}")
        content = content.replace(f"http://{domain}", f"{PROTOCOL}{NEW_DOMAIN}")
        # Just in case there are naked domains in some texts (unlikely for canonicals but good for consistency)
        # content = content.replace(domain, NEW_DOMAIN) 
        # CAREFUL: "writeoffcalc.com" might be part of an email or something else. 
        # Given the context (canonicals, sitemaps), replacing the full URL is safer.
        
    return content

def main():
    modified_count = 0
    for root, dirs, files in os.walk(TARGET_DIR):
        for file in files:
            if file.endswith(('.html', '.xml', '.txt', '.php', '.json')):
                file_path = os.path.join(root, file)
                try:
                    with open(file_path, 'r', encoding='utf-8') as f:
                        content = f.read()
                    
                    new_content = fix_content(content)
                    
                    if new_content != content:
                        print(f"Fixing: {file_path}")
                        with open(file_path, 'w', encoding='utf-8') as f:
                            f.write(new_content)
                        modified_count += 1
                except Exception as e:
                    print(f"Error processing {file_path}: {e}")

    print(f"Total files modified: {modified_count}")

if __name__ == "__main__":
    main()
