$files = @(
    'chat.blade.php',
    'dashboard.blade.php',
    'notifications.blade.php',
    'order-details.blade.php',
    'orders.blade.php',
    'partners.blade.php'
)

$commit = "d78648d4ef1d8f008da2e3bfefc0cd53578950a1"
$baseDir = "resources/views/templates/customer"

if (-Not (Test-Path $baseDir)) {
    New-Item -ItemType Directory -Force -Path $baseDir
}

foreach ($file in $files) {
    # Ambil file dari commit masa lalu dan timpa ke folder templates
    $source = "resources/views/customer/$file"
    $dest = "$baseDir/$file"
    git show "$commit`:$source" | Out-File -Encoding utf8 "$dest"
    Write-Host "Berhasil memulihkan $file"
}

# Sekarang kembalikan layout ke nama yang benar
foreach ($file in $files) {
    $dest = "$baseDir/$file"
    $content = Get-Content $dest -Raw
    $content = $content -replace "@extends\('layouts.customer'\)", "@extends('layouts.customer-layout')"
    
    # Tambahkan script tag logic
    if ($content -match "@push\('scripts'\)") {
        $content = $content -replace "@push\('scripts'\)", "@push('scripts')`r`n<script>"
        $content = $content -replace "@endpush", "</script>`r`n@endpush"
    }

    Set-Content $dest $content -Encoding UTF8
}

Write-Host "Semua proses selesai!"
