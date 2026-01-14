<?php
// NO CSP VERSION - For testing if CSP is the issue
// This file has NO Content-Security-Policy headers at all
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devycore - NO CSP Test</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #0a0a0a;
            color: #00ff88;
        }
        h1 { color: #ff0055; }
        .test { margin: 20px 0; padding: 20px; border: 2px solid #00ff88; }
        .success { color: #00ff88; }
        .error { color: #ff0055; }
    </style>
</head>
<body>
    <h1>CSP Test - NO CSP Headers</h1>
    <p>This page has NO Content-Security-Policy headers.</p>
    <p>If images/scripts still fail, CSP is coming from browser extension or network.</p>

    <div class="test">
        <h2>Test 1: External Image</h2>
        <img src="https://via.placeholder.com/300x200/0a0a0a/00ff88?text=TEST" alt="Test Image" />
        <p id="img-result">Loading image...</p>
    </div>

    <div class="test">
        <h2>Test 2: Three.js from CDN</h2>
        <p id="three-result">Loading Three.js...</p>
    </div>

    <div class="test">
        <h2>Test 3: Check Console</h2>
        <p>Open DevTools (F12) and check Console tab.</p>
        <p>If you see CSP errors, they're NOT from this page!</p>
    </div>

    <script>
        // Test image load
        const img = document.querySelector('img');
        img.onload = () => {
            document.getElementById('img-result').innerHTML = '<span class="success">✓ Image loaded successfully!</span>';
        };
        img.onerror = () => {
            document.getElementById('img-result').innerHTML = '<span class="error">✗ Image failed (check console)</span>';
        };

        // Test Three.js load
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js';
        script.onload = () => {
            document.getElementById('three-result').innerHTML =
                '<span class="success">✓ Three.js loaded! Version: ' + window.THREE.REVISION + '</span>';
        };
        script.onerror = () => {
            document.getElementById('three-result').innerHTML =
                '<span class="error">✗ Three.js failed to load (check console)</span>';
        };
        document.head.appendChild(script);

        console.log('%c CSP TEST PAGE', 'background: #00ff88; color: #0a0a0a; font-size: 20px; padding: 10px;');
        console.log('This page has NO CSP headers.');
        console.log('If you see CSP violations, they are from:');
        console.log('1. Browser extension (e.g., privacy/security extension)');
        console.log('2. Antivirus software');
        console.log('3. Network proxy/firewall');
        console.log('4. Browser settings');
    </script>
</body>
</html>
