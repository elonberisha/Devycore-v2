# Content Security Policy (CSP) Guide

## Current Issue

The CSP was being set somewhere (possibly browser extension or XAMPP default) and blocking:
- External images (via.placeholder.com)
- External scripts (Three.js CDNs)

## Solution Applied

Added CSP headers directly in PHP at the top of [public/index.php](public/index.php:1-7).

### Development Mode (Current)

**Very relaxed CSP** - allows everything for testing:

```php
header("Content-Security-Policy: default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: http: https:; connect-src *;");
```

This allows:
- ✅ All external scripts
- ✅ All external images
- ✅ All external fonts
- ✅ Inline scripts and styles
- ✅ eval() and dynamic code execution

## Production CSP (Recommended)

When deploying to production, replace the headers in [public/index.php](public/index.php) with:

```php
<?php
// PRODUCTION MODE - Strict CSP
header("Content-Security-Policy: " .
    "default-src 'self'; " .
    "script-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com; " .
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
    "font-src 'self' https://fonts.gstatic.com; " .
    "img-src 'self' data: blob: https:; " .
    "connect-src 'self'; " .
    "frame-ancestors 'none'; " .
    "base-uri 'self'; " .
    "form-action 'self';"
);
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
?>
```

## Why CSP is Important

CSP prevents:
- **XSS attacks** - Blocks malicious scripts
- **Data injection** - Prevents unauthorized resources
- **Clickjacking** - Stops iframe embedding
- **Mixed content** - Forces HTTPS

## Debugging CSP Issues

### Check Headers
```bash
curl -I http://localhost/devycore-v2/public/
```

Look for:
```
Content-Security-Policy: default-src *; script-src * ...
```

### Browser Console
- Open DevTools (F12)
- Go to Console tab
- Look for CSP violations

### Common Errors

**Error**: `violates the following Content Security Policy directive: "img-src 'self'"`
**Fix**: Add `https:` to `img-src`

**Error**: `violates the following Content Security Policy directive: "script-src ..."`
**Fix**: Add the CDN domain to `script-src`

## CSP Directives Explained

| Directive | Purpose | Our Setting |
|-----------|---------|-------------|
| `default-src` | Fallback for all directives | `*` (dev) / `'self'` (prod) |
| `script-src` | JavaScript sources | `* 'unsafe-inline' 'unsafe-eval'` (dev) |
| `style-src` | CSS sources | `* 'unsafe-inline'` (dev) |
| `img-src` | Image sources | `* data: blob: http: https:` |
| `font-src` | Font sources | `* data:` |
| `connect-src` | Fetch/XHR sources | `*` (dev) / `'self'` (prod) |
| `frame-ancestors` | Embedding in iframes | `'none'` |
| `base-uri` | Base tag URLs | `'self'` |
| `form-action` | Form submission URLs | `'self'` |

## Special Values

- `'self'` - Same origin only
- `'none'` - Block all
- `*` - Allow all origins (use in dev only!)
- `'unsafe-inline'` - Allow inline scripts/styles
- `'unsafe-eval'` - Allow eval() and similar
- `data:` - Allow data: URIs
- `blob:` - Allow blob: URIs
- `https:` - Allow all HTTPS sources
- `http:` - Allow all HTTP sources

## Testing CSP

### 1. Test Images Load
```javascript
// In browser console
const img = new Image();
img.src = 'https://via.placeholder.com/150';
document.body.appendChild(img);
// Should load without CSP errors
```

### 2. Test External Scripts
```javascript
// In browser console
const script = document.createElement('script');
script.src = 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js';
document.head.appendChild(script);
// Should load without CSP errors
```

### 3. Test API Calls
```javascript
// In browser console
fetch('/devycore-v2/public/api/projects.php')
  .then(r => r.json())
  .then(console.log);
// Should work without CSP errors
```

## Migration Path

### Phase 1: Development (Current)
- **CSP**: Very relaxed (`*` everywhere)
- **Goal**: Get everything working
- **Duration**: Until all features tested

### Phase 2: Staging
- **CSP**: Moderate (specific CDNs)
- **Goal**: Test with real-world CSP
- **Action**: Use "Production CSP" from above

### Phase 3: Production
- **CSP**: Strict (minimal permissions)
- **Goal**: Maximum security
- **Action**: Remove `'unsafe-inline'` and `'unsafe-eval'`

## Advanced: Removing unsafe-inline

To remove `'unsafe-inline'` from production:

1. **Extract inline styles** to external CSS files
2. **Extract inline scripts** to external JS files
3. **Use nonces** for required inline code:

```php
<?php
$nonce = base64_encode(random_bytes(16));
header("Content-Security-Policy: script-src 'self' 'nonce-$nonce';");
?>
<script nonce="<?= $nonce ?>">
  // Inline code here
</script>
```

## Resources

- [MDN CSP Guide](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)
- [CSP Evaluator](https://csp-evaluator.withgoogle.com/)
- [Report URI](https://report-uri.com/home/generate)

## Current Status

✅ **Development CSP active** - All resources loading
⏳ **Production CSP ready** - Use when deploying

**Last Updated**: 2026-01-10

---

**Rifresko browser-in tani (Ctrl + Shift + R) dhe errort CSP duhet të zhduken!**
