import re
import os

filepath = r'c:\HVAC load calc\public\blog.html'
image_mapping = {
    'How Insulation Affects HVAC Load': 'insulation_impact_chart.webp',
    'How Windows Affect HVAC Load': 'solar_heat_gain_diagram.webp',
    'Air Leakage, ACH, and Infiltration': 'blog-2.webp',
    'When You Should Hire a Pro for a Manual J': 'blog-3.webp'
}

try:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Fix Double Closing Divs
    # Search for the specific img tag ending followed by two closing divs
    # The first closing div is correct (closes the wrapper), the second is the orphan.
    # Pattern: ></div>\s+</div>
    # We rely on the class signature of the img to be specific.
    
    img_sig = r'group-hover:scale-105"></div>'
    
    db_pattern = re.compile(f'({img_sig})\s+</div>')
    
    if db_pattern.search(content):
        content = db_pattern.sub(r'\1', content)
        print("Fixed double closing divs.")
    else:
        print("No double closing divs found (or pattern mismatch).")

    # 2. Add Missing Images
    # We iterate by article again
    articles = content.split('<article')
    new_content = articles[0]

    for i in range(1, len(articles)):
        fragment = articles[i]
        
        # Check title
        title_match = re.search(r'<h2[^>]*>(.*?)</h2>', fragment, re.DOTALL)
        if title_match:
            full_title = title_match.group(1).strip()
            clean_title = re.sub(r'<[^>]+>', '', full_title)
            clean_title = ' '.join(clean_title.split())
            
            # Check if this article needs an image
            image_name = None
            for key, img in image_mapping.items():
                if key in clean_title or clean_title in key:
                    image_name = img
                    break
            
            if image_name:
                # Check if it already has an image or placeholder class
                if 'h-48' not in fragment and '<img' not in fragment:
                    print(f"Adding missing image for: {clean_title}")
                    
                    # Create image block
                    # For the Hire a Pro one (wide), h-48 might be too short, lets use h-64 for that one?
                    # Or keep consistent h-48. h-48 is 12rem (192px).
                    # 'When You Should Hire a Pro...'
                    
                    height_class = "h-48"
                    if "Hire a Pro" in clean_title:
                        height_class="h-64 md:h-80"
                        
                    img_block = f'<div class="{height_class} w-full relative overflow-hidden"><img src="assets/images/{image_name}" alt="{clean_title}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"></div>'
                    
                    # Insert before the first inner div (usually p-6 or p-8)
                    # We look for the first <div inside the fragment
                    # The fragment starts with class attributes of article tag > ...
                    
                    # The fragment string starts like: ' class="..."> \n <div ...'
                    # We just find the first '>' that closes the article tag attributes?
                    # No, content.split('<article') removes '<article'. 
                    # So fragment starts with ' class="...">...'
                    
                    # Find the end of the opening article tag
                    tag_end = fragment.find('>')
                    if tag_end != -1:
                        # Insert after tag_end
                        fragment = fragment[:tag_end+1] + '\n' + img_block + fragment[tag_end+1:]
        
        new_content += '<article' + fragment

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Finished fixing blog completeness.")

except Exception as e:
    print(f"Error: {e}")
