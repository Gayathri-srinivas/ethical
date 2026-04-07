<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    if (!ob_start('ob_gzhandler')) {
        ob_start();
    }
} catch (Exception $e) {
    ob_start();
}

try {
    $bookNumber = isset($_GET['book']) ? intval($_GET['book']) : 0;
    
    error_log("===== ENGLISH BOOK REQUEST =====");
    error_log("Book number: " . $bookNumber);
    
    if ($bookNumber < 1 || $bookNumber > 66) {
        http_response_code(400);
        echo json_encode([
            'error' => true, 
            'message' => 'Book number must be between 1 and 66'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // ⭐ FIXED: Use associative array with exact Bible order
    $bookFiles = [
        1 => "Genesis",
        2 => "Exodus", 
        3 => "Leviticus",
        4 => "Numbers",
        5 => "Deuteronomy",
        6 => "Joshua",
        7 => "Judges",
        8 => "Ruth",
        9 => "1 Samuel",
        10 => "2 Samuel",
        11 => "1 Kings",
        12 => "2 Kings",
        13 => "1 Chronicles",
        14 => "2 Chronicles",
        15 => "Ezra",
        16 => "Nehemiah",
        17 => "Esther",
        18 => "Job",
        19 => "Psalms",
        20 => "Proverbs",
        21 => "Ecclesiastes",
        22 => "Song Of Solomon",
        23 => "Isaiah",
        24 => "Jeremiah",
        25 => "Lamentations",
        26 => "Ezekiel",
        27 => "Daniel",
        28 => "Hosea",
        29 => "Joel",
        30 => "Amos",
        31 => "Obadiah",
        32 => "Jonah",
        33 => "Micah",
        34 => "Nahum",
        35 => "Habakkuk",
        36 => "Zephaniah",
        37 => "Haggai",
        38 => "Zechariah",
        39 => "Malachi",
        40 => "Matthew",
        41 => "Mark",
        42 => "Luke",
        43 => "John",
        44 => "Acts",
        45 => "Romans",
        46 => "1 Corinthians",
        47 => "2 Corinthians",
        48 => "Galatians",
        49 => "Ephesians",
        50 => "Philippians",
        51 => "Colossians",
        52 => "1 Thessalonians",
        53 => "2 Thessalonians",
        54 => "1 Timothy",
        55 => "2 Timothy",
        56 => "Titus",
        57 => "Philemon",
        58 => "Hebrews",
        59 => "James",
        60 => "1 Peter",
        61 => "2 Peter",
        62 => "1 John",
        63 => "2 John",
        64 => "3 John",
        65 => "Jude",
        66 => "Revelation"
    ];
    
    if (!isset($bookFiles[$bookNumber])) {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'Invalid book number',
            'book_number' => $bookNumber
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $fileName = $bookFiles[$bookNumber];
    $filePath = __DIR__ . '/EngBooks/' . $fileName . '.json';
    
    error_log("Book name: " . $fileName);
    error_log("Full path: " . $filePath);
    error_log("File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));
    
    // ⭐ IMPORTANT: New cache key version to invalidate old cache
    $cacheKey = 'bible_book_english_v3_' . $bookNumber;
    
    // APCu cache check
    if (function_exists('apcu_fetch')) {
        $data = apcu_fetch($cacheKey, $success);
        
        if ($success) {
            error_log("Cache HIT (v3)");
            header('X-Cache: HIT');
            header('X-Book-Name: ' . $fileName);
            header('Cache-Control: public, max-age=86400');
            echo $data;
            ob_end_flush();
            exit;
        }
    }
    
    // Load from file
    if (!file_exists($filePath)) {
        error_log("ERROR: File does not exist!");
        
        // Try to find the file in directory
        $dir = __DIR__ . '/EngBooks/';
        $allFiles = scandir($dir);
        $jsonFiles = array_filter($allFiles, function($f) {
            return pathinfo($f, PATHINFO_EXTENSION) === 'json';
        });
        
        http_response_code(404);
        echo json_encode([
            'error' => true, 
            'message' => 'File not found: ' . $fileName . '.json',
            'book_number' => $bookNumber,
            'looking_for' => $fileName,
            'path_checked' => $filePath,
            'available_files' => array_values($jsonFiles)
        ], JSON_UNESCAPED_UNICODE);
        ob_end_flush();
        exit;
    }
    
    error_log("Reading file...");
    $data = file_get_contents($filePath);
    
    if ($data === false) {
        error_log("ERROR: Failed to read file!");
        throw new Exception('Failed to read English book file');
    }
    
    error_log("File size: " . strlen($data) . " bytes");
    
    // Validate JSON
    $jsonTest = json_decode($data);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("ERROR: Invalid JSON - " . json_last_error_msg());
        throw new Exception('Invalid JSON in file: ' . json_last_error_msg());
    }
    
    error_log("JSON valid!");
    
    // Store in APCu cache for 24 hours with NEW cache key
    if (function_exists('apcu_store')) {
        apcu_store($cacheKey, $data, 86400);
        error_log("Stored in cache (v3)");
    }
    
    header('X-Cache: MISS');
    header('X-Book-Name: ' . $fileName);
    header('Cache-Control: public, max-age=86400');
    echo $data;
    error_log("Response sent successfully!");
    
} catch (Exception $e) {
    error_log("FATAL ERROR: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    http_response_code(500);
    echo json_encode([
        'error' => true, 
        'message' => 'Server error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], JSON_UNESCAPED_UNICODE);
}

ob_end_flush();
?>