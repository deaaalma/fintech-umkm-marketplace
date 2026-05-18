import os
import shutil

src = r"c:\laragon\www\umkm-website\resources\views\customer"
dst = r"c:\laragon\www\umkm-website\resources\views\templates\customer"

if not os.path.exists(dst):
    os.makedirs(dst)

for root, dirs, files in os.walk(src):
    for f in files:
        if f.endswith('.blade.php'):
            src_file = os.path.join(root, f)
            rel_path = os.path.relpath(root, src)
            dst_dir = os.path.join(dst, rel_path)
            if not os.path.exists(dst_dir):
                os.makedirs(dst_dir)
            
            dst_file = os.path.join(dst_dir, f)
            with open(src_file, 'r', encoding='utf-8') as file_r:
                content = file_r.read()
            
            # Ganti Layout
            content = content.replace("@extends('layouts.customer')", "@extends('layouts.customer-layout')")
            
            # Bungkus Scripts
            if "@push('scripts')" in content:
                content = content.replace("@push('scripts')", "@push('scripts')\n<script>")
                content = content.replace("@endpush", "</script>\n@endpush")
                
            with open(dst_file, 'w', encoding='utf-8') as file_w:
                file_w.write(content)

print(f"Berhasil menyalin dan memulihkan dari {src} ke {dst}")
