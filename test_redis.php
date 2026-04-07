<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== REDIS CONNECTION TEST ===\n\n";

try {
    $redis = new Redis();
    
    // Try to connect (common Redis configurations)
    $connected = false;
    
    // Try localhost:6379 (default)
    if (@$redis->connect('127.0.0.1', 6379)) {
        $connected = true;
        echo "✅ Redis connected: 127.0.0.1:6379\n";
    } 
    // Try localhost socket
    elseif (@$redis->connect('/var/run/redis/redis.sock')) {
        $connected = true;
        echo "✅ Redis connected: Unix socket\n";
    }
    // Try without port (default)
    elseif (@$redis->connect('localhost')) {
        $connected = true;
        echo "✅ Redis connected: localhost\n";
    }
    
    if ($connected) {
        // Test read/write
        $testKey = 'test_' . time();
        $testValue = 'Redis is working! 🎉';
        
        $redis->set($testKey, $testValue, 10); // 10 seconds expiry
        $retrieved = $redis->get($testKey);
        
        if ($retrieved === $testValue) {
            echo "✅ Redis READ/WRITE working!\n";
            echo "\nRedis INFO:\n";
            echo "- Version: " . $redis->info()['redis_version'] . "\n";
            echo "- Used Memory: " . $redis->info()['used_memory_human'] . "\n";
            echo "- Connected Clients: " . $redis->info()['connected_clients'] . "\n";
            
            // Clean up
            $redis->del($testKey);
            
            echo "\n🚀 Redis is READY TO USE!\n";
            echo "\nYou can use Redis caching for your Bible app!\n";
        } else {
            echo "⚠️ Redis connected but READ/WRITE failed\n";
        }
    } else {
        echo "❌ Redis NOT connected\n";
        echo "\nPossible reasons:\n";
        echo "- Redis server not running\n";
        echo "- Redis not configured for your hosting\n";
        echo "- Connection credentials needed\n";
        echo "\n👉 Contact Hostinger support to enable Redis\n";
    }
    
} catch (Exception $e) {
    echo "❌ Redis Error: " . $e->getMessage() . "\n";
    echo "\n👉 Redis extension installed but server not available\n";
}
?>