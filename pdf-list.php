<?php
$dir = __DIR__ . '/downloads/';
$metaFile = $dir . 'metadata.json';

$metadata = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

$pdfs = array_filter(scandir($dir), function ($f) {
  return is_file(__DIR__ . '/downloads/' . $f) && pathinfo($f, PATHINFO_EXTENSION) === 'pdf';
});

usort($pdfs, function($a, $b) use ($dir) {
  return filemtime($dir . $b) - filemtime($dir . $a); // neueste zuerst
});

$output = "\n<ul class='pdf-list'>\n";
foreach ($pdfs as $pdf) {
  $filePath = 'downloads/' . $pdf;
  $year = isset($metadata[$pdf]['year']) ? $metadata[$pdf]['year'] : date('Y', filemtime($dir . $pdf));
  $desc = isset($metadata[$pdf]['desc']) ? $metadata[$pdf]['desc'] : 'Research paper';
  $output .= "<li>[{$year}] {$desc} – <a href='{$filePath}' target='_blank'>{$pdf}</a></li>\n";
}
$output .= "</ul>\n";

echo $output;
