import sys
from PIL import Image

def main():
    try:
        img_path = 'C:/Users/LENOVO/.gemini/antigravity/brain/57c1597f-febf-45e4-9a0b-9294e3bb74b6/uploaded_media_1773401597380.png'
        img = Image.open(img_path).convert('RGB')
        w, h = img.size
        # The image has 5 horizontal distinct color bands
        y = int(h * 0.4)
        x_positions = [int(w * x) for x in [0.1, 0.3, 0.5, 0.7, 0.9]]
        
        colors = []
        for x in x_positions:
            r, g, b = img.getpixel((x, y))
            colors.append(f"#{r:02x}{g:02x}{b:02x}")
            
        print("COLORS:", colors)
    except Exception as e:
        print("ERROR:", e)

if __name__ == '__main__':
    main()
