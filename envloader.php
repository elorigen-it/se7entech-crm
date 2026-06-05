<?php 
    $envPath = __DIR__ . '/.env';
    if (file_exists($envPath)) {
        $env = file_get_contents($envPath);
        $lines = explode("\n", str_replace("\r", "", $env));

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            
            if (preg_match('/^([^=]+)\=(.*)$/', $line, $matches)) {
                $key = trim($matches[1]);
                $val = trim($matches[2]);
                
                // Strip optional surrounding quotes (double, single, or backticks)
                if (preg_match('/^["\'`](.*)["\'`]$/', $val, $innerMatches)) {
                    $val = $innerMatches[1];
                }
                
                putenv("$key=$val");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
    }
?>