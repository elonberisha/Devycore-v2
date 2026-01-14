<?php
// DEVELOPMENT MODE - Relaxed CSP for testing
header("Content-Security-Policy: default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: http: https:; connect-src *;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");

echo "<h1>Headers Check</h1>";
echo "<pre>";
echo "Response Headers:\n";
echo "=================\n\n";

foreach (headers_list() as $header) {
    echo $header . "\n";
}

echo "\n\nAll Request Headers:\n";
echo "====================\n\n";
print_r(getallheaders());

echo "\n\n";
phpinfo(INFO_GENERAL | INFO_VARIABLES);
echo "</pre>";
