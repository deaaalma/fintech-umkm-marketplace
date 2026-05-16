<?php
$imgPath = 'C:/Users/LENOVO/.gemini/antigravity/brain/57c1597f-febf-45e4-9a0b-9294e3bb74b6/uploaded_media_1773401597380.png';
$im = imagecreatefrompng($imgPath);
if (!$im) {
    die("Failed to create image");
}

$width = imagesx($im);
$height = imagesy($im);

$y = intval($height * 0.4);
$x_positions = [
    intval($width * 0.1),
    intval($width * 0.3),
    intval($width * 0.5),
    intval($width * 0.7),
    intval($width * 0.9)
];

$colors = [];
foreach ($x_positions as $x) {
    $rgb = imagecolorat($im, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    $colors[] = sprintf("#%02x%02x%02x", $r, $g, $b);
}

echo "COLORS: " . implode(" ", $colors) . "\n";
?>
