import re
import os

# Mapping of Article Title (normalized) -> Image Filename
image_mapping = {
    'What Is a Manual J Load Calculation?': 'manual-j-basics.webp',
    'How to Calculate HVAC Load (Step-by-Step)': 'how-to-calc-load.webp',
    'How Many BTUs Do I Need?': 'how-many-btus.webp',
    'HVAC Tonnage Explained': 'hvac-tonnage.webp',
    'Why Oversizing Your AC Is a Mistake': 'short-cycling.webp',
    'Manual J vs Rule-of-Thumb': 'rule-of-thumb.webp',
    'How Insulation Affects HVAC Load': 'insulation_impact_chart.webp',
    'How Windows Affect HVAC Load': 'solar_heat_gain_diagram.webp',
    'Air Leakage, ACH, and Infiltration': 'blog-2.webp',
    'When You Should Hire a Pro for a Manual J': 'blog-3.webp'
}

filepath = r'c:\HVAC load calc\public\blog.html'

try:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Split by <article to process each block
    articles = content.split('<article')
    new_content = articles[0]

    for i in range(1, len(articles)):
        fragment = articles[i]
        
        # 1. Identify the article title
        # Use simple regex, then normalize whitespace
        title_match = re.search(r'<h2[^>]*>(.*?)</h2>', fragment, re.DOTALL)
        
        updated_fragment = fragment
        
        if title_match:
            full_title = title_match.group(1).strip()
            # Remove HTML tags
            clean_title = re.sub(r'<[^>]+>', '', full_title)
            # Normalize whitespace: replace newlines and multiple spaces with single space
            clean_title = ' '.join(clean_title.split())
            
            print(f"Found title: '{clean_title}'")
            
            # 2. Find matching image
            image_name = None
            # Check for partial match if exact match fails
            for key, img in image_mapping.items():
                if key in clean_title or clean_title in key:
                    image_name = img
                    break
            
            if image_name:
                print(f"  -> Match found: {image_name}")
                
                # 3. Regex to find the placeholder div
                # Looking for the div with class="h-48 ..." that contains an svg
                # We'll target the wrapper div directly.
                
                # Pattern: <div class="h-48 ..."> ... </div>
                # But we must be careful not to match the ARTICLE div or others.
                # The placeholder is usually the first div inside the article (or close to top).
                # It has 'h-48' and 'relative' and 'overflow-hidden'.
                
                div_pattern = r'(<div class="h-48[^"]*relative overflow-hidden">)(.*?)(</div>)'
                
                def replacement(match):
                    opener = match.group(1)
                    # Replace bg color with bg-gray-100 or keep it? 
                    # Prefer removing bg-color classes to avoid clash, but let's just make sure it displays the img.
                    # We can replace the whole opener class string if we want, but preserving h-48 is good.
                    
                    # Ensure opener has 'group' class if needed? No, article has 'group'.
                    # Add image
                    img_tag = f'<img src="assets/images/{image_name}" alt="{clean_title}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">'
                    return f'{opener}{img_tag}{match.group(3)}'
                
                if re.search(div_pattern, updated_fragment, re.DOTALL):
                    updated_fragment = re.sub(div_pattern, replacement, updated_fragment, count=1, flags=re.DOTALL)
                    print("  -> Updated HTML fragment")
                else:
                    print("  -> WARNING: Could not find placeholder div in fragment")
            else:
                print("  -> NO MATCH in mapping")
        
        new_content += '<article' + updated_fragment

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_content)
        
    print("Finished processing blog.html")

except Exception as e:
    print(f"Error: {e}")
