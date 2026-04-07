<?php
header('Content-Type: application/json; charset=utf-8');

// ✅ Enable compression
if (!ob_start('ob_gzhandler')) {
    ob_start();
}

// ✅ Get language parameter from query string
$language = isset($_GET['lang']) ? strtolower($_GET['lang']) : 'telugu';

// ✅ Validate language
if (!in_array($language, ['telugu', 'english'])) {
    $language = 'telugu';
}

// ✅ Set cache key based on language
$cacheKey = 'bible_search_data_' . $language . '_v3';
$cacheTTL = 86400; // 24 hours

// ✅ Set file path based on language
$filePath = $language === 'english' 
    ? __DIR__ . '/eng_bible_minified.json'
    : __DIR__ . '/logicallaw_minified.json';

// ⭐⭐⭐ APCu with igbinary
if (function_exists('apcu_fetch')) {
    $data = apcu_fetch($cacheKey, $success);
    
    if ($success) {
        header('X-Cache: HIT');
        header('X-Language: ' . $language);
        header('Content-Length: ' . strlen($data));
        echo $data;
        exit;
    }
}

// Cache miss - load from file
if (!file_exists($filePath)) {
    http_response_code(404);
    echo json_encode([
        'error' => true,
        'message' => "Search data file not found for language: {$language}",
        'file' => basename($filePath)
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = file_get_contents($filePath);
if ($data === false) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to read search data'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ⭐ Store in APCu (igbinary will compress automatically)
if (function_exists('apcu_store')) {
    apcu_store($cacheKey, $data, $cacheTTL);
}

header('X-Cache: MISS');
header('X-Language: ' . $language);
header('Content-Length: ' . strlen($data));
echo $data;
ob_end_flush();
?>