<?php
require __DIR__ . '/includes/function.php';
header('Content-Type: application/json; charset=utf-8');

$file = __DIR__ . '/data/sociograma.json';
$data = load_json($file);

echo json_encode([
    'count' => count($data),
    'items' => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
