<?php
// test_apcu.php
echo "APCu Functions Available: " . (function_exists('apcu_fetch') ? 'YES ✅' : 'NO ❌') . "\n";
echo "APCu Enabled: " . (ini_get('apc.enabled') ? 'YES ✅' : 'NO ❌') . "\n";

if (function_exists('apcu_fetch')) {
    echo "\nAPCu is WORKING! You can use it! 🎉\n";
} else {
    echo "\nAPCu is NOT available. Use IndexedDB solution instead.\n";
}

// Show all loaded extensions
echo "\n\nAll PHP Extensions:\n";
print_r(get_loaded_extensions());
?>