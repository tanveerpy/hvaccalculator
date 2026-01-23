import os
import re

# Components Template
# We use a placeholder {prefix} for relative paths (e.g., "" or "../")

NAV_TEMPLATE = """    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{prefix}index.html" class="flex items-center group">
                        <span class="text-xl font-extrabold text-blue-600 tracking-tight group-hover:text-blue-700 transition">HVAC<span class="text-slate-900 group-hover:text-slate-700 transition">Calc</span></span>
                    </a>
                </div>

                <!-- Main Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{prefix}index.html" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">Calculator</a>
                    <a href="{prefix}blog.html" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">Blog</a>
                    <a href="{prefix}about.html" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">About</a>
                    <a href="{prefix}contact.html" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">Contact</a>
                </div>
            </div>
        </div>
    </nav>"""

FOOTER_TEMPLATE = """    <footer class="bg-slate-900 text-slate-400 py-12 px-4 border-t border-slate-800">
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8 items-center">
            <!-- Col 1: Logo & Tagline -->
            <div class="text-center md:text-left">
                <a href="{prefix}index.html" class="inline-block mb-4">
                    <span class="text-2xl font-extrabold text-blue-500 tracking-tight">HVAC<span class="text-white">Calc</span></span>
                </a>
                <p class="text-sm text-slate-500">Professional-grade Manual J load calculations for homeowners and DIYers.</p>
                <p class="text-xs text-slate-600 mt-2">&copy; 2026 HVAC Load Calculator.</p>
            </div>

            <!-- Col 2: Links (Centered) -->
            <div class="flex flex-col items-center space-y-3">
                <a href="{prefix}index.html" class="hover:text-white transition">Home</a>
                <a href="{prefix}blog.html" class="hover:text-white transition">Blog</a>
                <a href="{prefix}privacy.html" class="hover:text-white transition">Privacy Policy</a>
                <a href="{prefix}terms.html" class="hover:text-white transition">Terms of Service</a>
                <a href="{prefix}contact.html" class="hover:text-white transition">Contact</a>
            </div>

            <!-- Col 3: Social Icons -->
            <div class="flex justify-center md:justify-end space-x-6">
                <!-- Twitter/X -->
                <a href="#" class="text-slate-500 hover:text-blue-400 transition" aria-label="Twitter">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <!-- Facebook -->
                <a href="#" class="text-slate-500 hover:text-blue-600 transition" aria-label="Facebook">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <!-- LinkedIn -->
                <a href="#" class="text-slate-500 hover:text-blue-500 transition" aria-label="LinkedIn">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
            </div>
        </div>
    </footer>"""

def standardize_ui(base_dir):
    # files to process: top level htmls and articles htmls
    
    # 1. Root files
    root_files = [f for f in os.listdir(base_dir) if f.endswith('.html')]
    for file in root_files:
        process_file(os.path.join(base_dir, file), prefix="")

    # 2. Article files
    articles_dir = os.path.join(base_dir, 'articles')
    if os.path.exists(articles_dir):
        article_files = [f for f in os.listdir(articles_dir) if f.endswith('.html')]
        for file in article_files:
            process_file(os.path.join(articles_dir, file), prefix="../")

def process_file(filepath, prefix):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        original_content = content

        # Replace Nav
        # Regex to find <nav ...> ... </nav>
        # We handle multiline and varied attributes
        nav_pattern = r'<nav[^>]*>.*?</nav>'
        new_nav = NAV_TEMPLATE.format(prefix=prefix)
        
        # Check if file has nav
        if re.search(nav_pattern, content, re.DOTALL):
            content = re.sub(nav_pattern, new_nav, content, flags=re.DOTALL)
        else:
            print(f"[{filepath}] No <nav> tag found to replace.")

        # Replace Footer
        footer_pattern = r'<footer[^>]*>.*?</footer>'
        new_footer = FOOTER_TEMPLATE.format(prefix=prefix)
        
        if re.search(footer_pattern, content, re.DOTALL):
            content = re.sub(footer_pattern, new_footer, content, flags=re.DOTALL)
        else:
            # Special case: some files might not have footer or have different structure
            # but usually we want to replace existing one.
            print(f"[{filepath}] No <footer> tag found to replace.")

        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated {filepath}")
        else:
            print(f"No changes for {filepath}")

    except Exception as e:
        print(f"Error processing {filepath}: {e}")

if __name__ == "__main__":
    standardize_ui(r'c:\HVAC load calc\public')
