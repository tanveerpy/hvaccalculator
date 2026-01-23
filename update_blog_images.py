import re

# Mapping of Article Title (or key phrase) -> Image Filename
# Based on the content of blog.html from previous inspection
image_mapping = {
    'What Is a Manual J Load Calculation?': 'manual-j-basics.webp',
    'How to Calculate HVAC Load': 'how-to-calc-load.webp',
    'How Many BTUs Do I Need?': 'how-many-btus.webp',
    'HVAC Tonnage Explained': 'hvac-tonnage.webp',
    'Why Oversizing Your AC Is a Mistake': 'short-cycling.webp',
    'Manual J vs Rule-of-Thumb': 'rule-of-thumb.webp',
    'How Insulation Affects HVAC Load': 'insulation_impact_chart.webp',
    'How Windows Affect HVAC Load': 'solar_heat_gain_diagram.webp', # Best fit available
    'Air Leakage, ACH, and Infiltration': 'blog-2.webp', # Generic
    'When You Should Hire a Pro': 'blog-3.webp' # Generic pro
}

filepath = r'c:\HVAC load calc\public\blog.html'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# We need to find each article block and replace the placeholder div.
# The articles are structured as:
# <article ...>
#    <div class="h-48 ... relative overflow-hidden"> ... </div>
#    <div class="p-6 ...">
#       ...
#       <h2 ...>Title</h2>
#       ...
#    </div>
# </article>

# Strategy: Find the h2 title first, then look backwards to find the preceding placeholder div and replace it.
# Or simpler: Split by <article, iterate, replace the first div inside with img based on the h2 found inside.

articles = content.split('<article')
new_content = articles[0] # Header part

for i in range(1, len(articles)):
    fragment = articles[i]
    
    # 1. Identify the article title
    title_match = re.search(r'<h2[^>]*>(.*?)</h2>', fragment, re.DOTALL)
    if title_match:
        full_title = title_match.group(1).strip()
        # Remove spans or extra tags if any (basic cleanup)
        clean_title = re.sub(r'<[^>]+>', '', full_title).strip()
        
        # 2. Find matching image
        image_name = None
        for key, img in image_mapping.items():
            if key in clean_title:
                image_name = img
                break
        
        if image_name:
            # 3. meaningful regex to find the placeholder div
            # The placeholder is the first div with h-48 class inside the article fragment
            # We want to replace the entire div content or the div itself?
            # User wants "Featured images". The div acts as a wrapper.
            # Let's replace the *contents* of the div (the svg part) with the img, 
            # OR replace the whole div to ensure styling is correct for an image.
            
            # The current div: <div class="h-48 bg-blue-50 w-full relative overflow-hidden"> ... </div>
            # We want: <div class="h-48 w-full relative overflow-hidden"> <img ...> </div>
            
            # Regex for the div wrapper.
            # It starts at the beginning of the fragment (mostly)
            # fragment starts with classes for the article tag> ...
            
            # Let's verify structure:
            # fragment = ' class="..."> \n <div class="h-48 ...">...</div> ... '
            
            # Regex to match the placeholder div
            # looking for <div class="h-48 ..."> ... </div>
            # Note: The div has nested div and svg.
            
            pattern = r'(<div class="h-48 [^"]*w-full relative overflow-hidden">)(.*?)(</div>)'
            
            def replacement(match):
                # match.group(1) is the opening tag. We might want to remove bg-color classes
                opener = match.group(1)
                # Remove bg- classes from opener to avoid color flashing behind image
                opener = re.sub(r'bg-[a-z]+-\d+', 'bg-gray-100', opener)
                
                img_tag = f'<img src="assets/images/{image_name}" alt="{clean_title}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">'
                return f'{opener}{img_tag}{match.group(3)}'
            
            # Apply replacement only once (the first one found in this fragment)
            fragment = re.sub(pattern, replacement, fragment, count=1, flags=re.DOTALL)
            print(f"Updated image for: {clean_title} -> {image_name}")

    new_content += '<article' + fragment

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(new_content)
    
print("Finished updating blog.html")
