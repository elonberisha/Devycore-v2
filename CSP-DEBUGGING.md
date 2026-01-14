# CSP Debugging Guide

## Problem: CSP Errors Still Showing

If you're still seeing CSP errors like:
```
Loading the image 'https://via.placeholder.com/...' violates the following
Content Security Policy directive: "img-src 'self' data: blob:"
```

Even after we added CSP headers, the CSP is likely coming from somewhere else.

---

## Step 1: Test Pages

We've created test pages to identify the source:

### A) Test with NO CSP
Open: http://localhost/devycore-v2/public/index-no-csp.php

This page has **ZERO** CSP headers. If you still see CSP errors, then:
- ✅ It's NOT from our code
- ✅ It's from browser extension, antivirus, or network

### B) CSP Detection Test
Open: http://localhost/devycore-v2/public/test-csp.html

Click the buttons to:
1. Check current CSP
2. Test image loading
3. Test script loading
4. View response headers

### C) Check Headers API
Open: http://localhost/devycore-v2/public/check-headers.php

This shows all HTTP headers being sent by the server.

---

## Step 2: Identify CSP Source

The CSP showing in your errors is:
```
img-src 'self' data: blob:
script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://unpkg.com
```

But our CSP is:
```
img-src * data: blob: http: https:
script-src * 'unsafe-inline' 'unsafe-eval'
```

**They don't match!** This means CSP is coming from:

### Possible Sources:

#### 1. Browser Extension 🔴 Most Likely
**Common extensions that inject CSP:**
- uBlock Origin
- Privacy Badger
- NoScript
- HTTPS Everywhere
- Any "Privacy" or "Security" extension

**Solution:**
- Open browser in **Incognito/Private mode** (disables extensions)
- Press: `Ctrl + Shift + N` (Chrome) or `Ctrl + Shift + P` (Firefox)
- Navigate to: http://localhost/devycore-v2/public/
- Check if CSP errors persist

If errors DISAPPEAR in incognito → It's a browser extension!

#### 2. Antivirus Software
Some antivirus programs inject CSP headers:
- Kaspersky
- Avast
- AVG
- Norton

**Solution:**
- Temporarily disable antivirus web protection
- Test the site
- If CSP errors disappear → It's the antivirus

#### 3. Network Proxy/Firewall
Corporate networks or parental controls can inject CSP.

**Solution:**
- Test from a different network
- Use mobile hotspot
- Check router/firewall settings

#### 4. Browser Settings
Some browsers have built-in CSP enforcement.

**Solution:**
- Clear browser cache: `Ctrl + Shift + Delete`
- Reset browser settings
- Try a different browser (Chrome vs Firefox vs Edge)

---

## Step 3: Solutions

### Solution A: Disable Extension (Temporary)

1. Open browser extensions: `chrome://extensions/`
2. Disable all "Privacy" and "Security" extensions
3. Reload page
4. Check if CSP errors gone

### Solution B: Add Exception in Extension

If using uBlock Origin or similar:
1. Click extension icon
2. Find CSP or "Block CSP" option
3. Add `localhost` to whitelist

### Solution C: Use Different Browser

Test in:
- ✅ Chrome Incognito
- ✅ Firefox Private Window
- ✅ Edge InPrivate
- ✅ Brave (without shields)

### Solution D: Accept It

WebGL and external images are **optional enhancements**:
- ✅ Site works without them
- ✅ Animations still work
- ✅ Forms still work
- ✅ Everything else functional

Users on production won't have your extensions!

---

## Step 4: Verify Our CSP is Working

### Check Response Headers

Open DevTools (F12) → Network tab:

1. Reload page
2. Click first request (document)
3. Go to "Headers" section
4. Look for `Content-Security-Policy`

**Expected:**
```
Content-Security-Policy: default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; ...
```

If you see this → Our CSP is working!
If you DON'T see this → Apache not reading PHP headers

### Check Meta Tag

View page source (Ctrl + U):

Look for:
```html
<meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline' ...">
```

If you see this → Meta CSP is set!

---

## Step 5: Production Workaround

If CSP issues persist in development but you need to continue:

### Option 1: Disable WebGL Temporarily

Edit [public/assets/js/main.js](public/assets/js/main.js):

```javascript
function scheduleLazyWebGL() {
  // TEMPORARY: Disable WebGL until CSP issue resolved
  console.log('WebGL disabled for CSP debugging');
  return;

  // ... rest of code
}
```

### Option 2: Use Local Three.js

Download Three.js locally instead of CDN:

```bash
# Download Three.js
curl -o public/assets/js/three.min.js https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js
```

Edit [public/assets/js/webgl.js](public/assets/js/webgl.js):

```javascript
function loadThreeJS() {
  return new Promise((resolve, reject) => {
    const script = document.createElement('script');
    script.src = '/devycore-v2/public/assets/js/three.min.js'; // Local file
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
  });
}
```

### Option 3: Use Data URLs for Images

Replace placeholder images with data URLs or local images.

---

## Step 6: What We've Done

✅ Added CSP headers in PHP (`index.php` line 3-6)
✅ Added CSP meta tag in HTML (`index.php` line 16)
✅ Created relaxed development CSP (allows everything)
✅ Created test pages to identify CSP source
✅ Documented all possible sources

---

## Quick Diagnosis

Run this in browser console:

```javascript
// Check CSP source
const meta = document.querySelector('meta[http-equiv="Content-Security-Policy"]');
console.log('Meta CSP:', meta ? meta.content : 'NOT FOUND');

// Fetch and check headers
fetch(window.location.href, {method: 'HEAD'})
  .then(r => {
    console.log('Response CSP:', r.headers.get('content-security-policy'));
  });

// Listen for violations
document.addEventListener('securitypolicyviolation', (e) => {
  console.error('CSP VIOLATION DETECTED!');
  console.log('Blocked:', e.blockedURI);
  console.log('Directive:', e.violatedDirective);
  console.log('Policy:', e.originalPolicy);
});
```

---

## Final Recommendation

1. **Test in Incognito mode** first
2. If works there → **It's a browser extension**
3. **Disable extensions** one by one to find culprit
4. **Add localhost to extension whitelist**
5. **Continue development** - production users won't have issue

---

## Need Help?

If CSP errors persist even in:
- ✅ Incognito mode
- ✅ Different browser
- ✅ Different computer

Then provide:
1. Screenshot of Network tab headers
2. Screenshot of CSP violation in console
3. Output of `check-headers.php`

We'll investigate further!

---

**Most likely: It's a browser extension. Test in Incognito mode! 🎯**
