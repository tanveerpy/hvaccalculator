import os
from PIL import Image

def optimize_images(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.lower().endswith(('.png', '.jpg', '.jpeg', '.webp')):
                filepath = os.path.join(root, file)
                try:
                    with Image.open(filepath) as img:
                        # Get current size
                        width, height = img.size
                        file_size = os.path.getsize(filepath)
                        
                        # Resize if too large (e.g., width > 1200)
                        if width > 1200:
                            new_width = 1200
                            new_height = int((new_width / width) * height)
                            img = img.resize((new_width, new_height), Image.Resampling.LANCZOS)
                            print(f"Resized {file} from {width}x{height} to {new_width}x{new_height}")

                        # Save with optimization
                        # For PNG, use optimize=True. For JPG, quality=80 works well.
                        if file.lower().endswith('.png'):
                             # Check if it's RGBA (has transparency)
                            if img.mode in ('RGBA', 'LA') or (img.mode == 'P' and 'transparency' in img.info):
                                # Keep as PNG but optimize
                                # Try to convert to P mode (palette) if possible for smaller size, but generic optimize is safer for now
                                img.save(filepath, optimize=True, quality=85)
                            else:
                                # Start by saving as optimized PNG
                                img.save(filepath, optimize=True)
                                
                        elif file.lower().endswith(('.jpg', '.jpeg')):
                            img.save(filepath, optimize=True, quality=80)
                        
                        new_size = os.path.getsize(filepath)
                        print(f"Optimized {file}: {file_size/1024:.2f}KB -> {new_size/1024:.2f}KB")

                except Exception as e:
                    print(f"Error processing {file}: {e}")

if __name__ == "__main__":
    optimize_images(r'c:\HVAC load calc\public\assets\images')
    optimize_images(r'c:\HVAC load calc\public\assets\img')
