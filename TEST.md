# Devycore V2 - Testing Guide

## 🧪 Quick Test Checklist

### Prerequisites
- ✅ Composer dependencies installed (`composer install`)
- ✅ Database created (`devycore_v2`)
- ✅ Schema imported (`database/schema.sql`)
- ✅ Apache & MySQL running in XAMPP
- ✅ `.env` file configured

---

## 1. Backend API Tests

### Test 1: Login API
```bash
curl -X POST http://localhost/devycore-v2/public/api/auth.php/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"admin123"}'
```

**Expected**: `{"success":true,"data":{"token":"...","user":{...}}}`

### Test 2: Get Projects (Public)
```bash
curl http://localhost/devycore-v2/public/api/projects.php
```

**Expected**: `{"success":true,"data":{"projects":[...]}}`

### Test 3: Contact Form
```bash
curl -X POST http://localhost/devycore-v2/public/api/contact.php \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "phone": "123456789",
    "company": "Test Co",
    "project_type": "Web Application",
    "company_type": "Startup",
    "message": "This is a test message",
    "website": ""
  }'
```

**Expected**: `{"success":true,"message":"Thank you! We will contact you soon."}`

---

## 2. Frontend Visual Tests

### Open Homepage
```
http://localhost/devycore-v2/public/
```

**Checklist**:
- [ ] Page loads without errors
- [ ] Brutalist design visible (black bg, green/pink accents, sharp borders)
- [ ] Grid overlay visible
- [ ] Header fixed at top with logo
- [ ] Hero section with large title
- [ ] Badges animated (subtle pulse)
- [ ] Cards have hover effects (translate + shadow)
- [ ] Glitch effect on hero title hover
- [ ] Navigation links work (smooth scroll)
- [ ] Hamburger menu on mobile (< 768px)

---

## 3. Animation Tests

### Hero Entrance
- [ ] Header slides down from top
- [ ] Badges scale in with stagger
- [ ] Hero title fades in from bottom
- [ ] Paragraph and buttons stagger in
- [ ] Balloon element appears with back ease

### Scroll Animations
- [ ] Cards fade in on scroll (Intersection Observer)
- [ ] Section numbers parallax slower than content
- [ ] List items animate with stagger
- [ ] Accent lines scale in

### GSAP Console Check
Open browser console and check for:
```
✓ Animations initialized
✓ GSAP animations ready
```

---

## 4. WebGL Tests

### Desktop Only (> 768px)
- [ ] WebGL canvas appears as background (after 2s or scroll)
- [ ] 150 particles visible (green/pink)
- [ ] Mouse movement creates parallax effect
- [ ] Particles drift slowly
- [ ] Console shows: `⚡ Initializing WebGL...` then `✓ WebGL initialized with 150 particles`

### Mobile (< 768px)
- [ ] No WebGL loaded (performance optimization)
- [ ] Console shows: `⚠ Skipping particles on mobile`

---

## 5. Prize Balloon Tests

### Initial State
- [ ] Balloon visible in hero section (right side)
- [ ] Text says "POP IT!"
- [ ] Hovers with float animation
- [ ] Cursor changes to pointer
- [ ] Hover scales balloon slightly

### Click Interaction
1. Click balloon
2. **Expected**:
   - [ ] Explosion animation (scale up then fade)
   - [ ] Particle burst (50 particles if WebGL loaded)
   - [ ] Prize result appears after 0.6s
   - [ ] Shows discount code OR "Better Luck!"
   - [ ] "CLAIM DISCOUNT" button visible (if win)
   - [ ] Cooldown timer starts (5 minutes)

### Cooldown
- [ ] Clicking again shows alert: "Please wait X more minute(s)"
- [ ] Timer displays: "Cooldown: 4:59" (counts down)
- [ ] After 5 minutes, balloon reappears
- [ ] LocalStorage keys set: `devy_prize_last`, `devy_prize_result`

### Reset Prize (Debug)
Open console:
```javascript
window.resetPrize()
```
Should reload page with balloon reset.

---

## 6. Form Tests

### Contact Form
1. Fill in all fields
2. Submit
3. **Expected**:
   - [ ] Spinner shows while submitting
   - [ ] Success message appears
   - [ ] Form resets
   - [ ] Form scales briefly (success animation)

### Validation Tests
Try submitting with:
- Empty name: Should show error
- Invalid email: Should show error
- Empty message: Should show error

---

## 7. Responsive Tests

### Desktop (> 1024px)
- [ ] 4-column grid for service cards
- [ ] 2-column split layout (hero, contact)
- [ ] Fixed header with full nav
- [ ] Grid background visible
- [ ] WebGL particles active

### Tablet (768px - 1024px)
- [ ] 2-column grid for service cards
- [ ] Single column split layouts
- [ ] Navigation collapses to hamburger
- [ ] Reduced font sizes

### Mobile (< 768px)
- [ ] 1-column grid for all cards
- [ ] Hamburger menu
- [ ] Mobile menu slides from right
- [ ] Reduced padding/spacing
- [ ] No WebGL (performance)
- [ ] Touch-friendly buttons (min 44px)

---

## 8. Performance Tests

### Lighthouse Audit
```bash
# Install Lighthouse CLI
npm install -g lighthouse

# Run audit
lighthouse http://localhost/devycore-v2/public/ --view
```

**Expected Scores**:
- Performance: > 85
- Accessibility: > 90
- Best Practices: > 90
- SEO: > 85

### Network Analysis
Open DevTools > Network:
- [ ] Total page size < 2MB
- [ ] CSS files load (4 files ~50kb total)
- [ ] JS files load (3 files initially, webgl.js lazy)
- [ ] GSAP from CDN loads successfully
- [ ] No 404 errors

### Console Errors
Check for:
- [ ] No JavaScript errors
- [ ] No CSS errors
- [ ] No CORS errors
- [ ] No 404s for assets

**Expected Console Output**:
```
🚀 Devycore V2
Brutalist Tech Design System
✓ Devycore V2
✓ Prize balloon initialized
✓ Animations initialized
✓ GSAP animations ready
⚡ Initializing WebGL...
✓ Three.js loaded
✓ WebGL initialized with 150 particles
```

---

## 9. Browser Compatibility

Test in:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)

**Known Issues**:
- WebGL may not work on older devices (gracefully degrades)
- Backdrop-filter may not work on Firefox (has fallback)

---

## 10. Database Verification

### Check Tables
```sql
USE devycore_v2;
SHOW TABLES;
```

**Expected**:
```
users
auth_tokens
projects
contact_submissions
discount_submissions
rate_limits
```

### Check Admin User
```sql
SELECT * FROM users;
```

**Expected**: 1 user (admin/super)

### Check Submissions
After testing contact form:
```sql
SELECT * FROM contact_submissions ORDER BY submitted_at DESC LIMIT 5;
```

Should see test submissions.

---

## 🐛 Common Issues & Fixes

### Issue: "Call to undefined function Devycore\..."
**Fix**: Run `composer install`

### Issue: CSS not loading
**Fix**: Check Apache is running, clear browser cache

### Issue: GSAP animations not working
**Fix**: Check browser console for CDN errors, may need internet connection

### Issue: WebGL not loading
**Fix**: Normal on mobile. On desktop, check console for errors.

### Issue: Contact form "Network error"
**Fix**: Check API endpoint path, verify Apache rewrite rules

### Issue: Database connection failed
**Fix**: Check MySQL is running, verify `.env` credentials

---

## ✅ Success Criteria

All systems go if:
- ✅ Homepage loads in < 2 seconds
- ✅ All API endpoints return JSON
- ✅ Contact form submits successfully
- ✅ GSAP animations play smoothly
- ✅ WebGL loads on desktop (optional on mobile)
- ✅ Prize balloon game works with cooldown
- ✅ No console errors
- ✅ Mobile responsive
- ✅ Lighthouse score > 85

---

## 📊 Performance Benchmarks

| Metric | Target | How to Measure |
|--------|--------|----------------|
| Load Time | < 1.5s | Lighthouse / Network tab |
| FCP | < 1s | Lighthouse |
| LCP | < 1.5s | Lighthouse |
| JS Size | < 200kb | Network tab (before WebGL) |
| CSS Size | < 100kb | Network tab |
| API Response | < 100ms | Network tab / Console |

---

**Happy Testing! 🚀**

If all tests pass, the project is ready for production deployment.
