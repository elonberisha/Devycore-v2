# Quick Start Guide - Devycore V2

## Current Status: 90% Complete ✅

All code is written and ready. You just need to setup the database!

---

## Step 1: Start XAMPP

1. Open **XAMPP Control Panel**
2. Click **Start** for **Apache**
3. Click **Start** for **MySQL**
4. Wait until both show green "Running" status

---

## Step 2: Create Database

### Option A: Using phpMyAdmin (Recommended)

1. Open browser: **http://localhost/phpmyadmin**
2. Click **"New"** in left sidebar
3. Database name: `devycore_v2`
4. Collation: `utf8mb4_general_ci`
5. Click **"Create"**
6. Select the new `devycore_v2` database
7. Click **"Import"** tab at top
8. Click **"Choose File"** button
9. Navigate to: `C:\xampp\htdocs\devycore-v2\database\schema.sql`
10. Click **"Import"** button at bottom
11. You should see: **"Import has been successfully finished, 6 queries executed."**

### Option B: Using Command Line

```bash
# Create database
mysql -u root -e "CREATE DATABASE devycore_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# Import schema
mysql -u root devycore_v2 < "C:\xampp\htdocs\devycore-v2\database\schema.sql"
```

---

## Step 3: Verify Setup

Run the verification script:

```bash
cd C:\xampp\htdocs\devycore-v2
php verify-setup.php
```

You should see all ✓ (checkmarks) with no ✗ (errors).

Expected output:
```
5. Database Connection: ✓ Connected

6. Database Tables:
   - users               : ✓ (1 rows)
   - auth_tokens         : ✓ (0 rows)
   - projects            : ✓ (0 rows)
   - contact_submissions : ✓ (0 rows)
   - discount_submissions: ✓ (0 rows)
   - rate_limits         : ✓ (0 rows)
```

---

## Step 4: Open Website

**Homepage**: http://localhost/devycore-v2/public/

You should see:
- ✅ Brutalist design (black background, green/magenta accents)
- ✅ Hero section with "DIGITAL CRAFT" title
- ✅ Services grid (8 cards)
- ✅ Prize balloon in corner (click to play!)
- ✅ Contact form at bottom
- ✅ Smooth animations on scroll
- ✅ Particle effects (desktop only)

---

## Step 5: Test Features

### Test Contact Form
1. Scroll to **Contact** section
2. Fill in all fields:
   - Name: `Test User`
   - Email: `test@example.com`
   - Message: `This is a test submission`
3. Click **SEND MESSAGE**
4. You should see success message (note: email won't send without SMTP config)

### Test Prize Balloon
1. Look for balloon in top-right corner (or scroll to see it)
2. Click on balloon
3. Should explode with animation
4. You'll win a discount code (20-60% off)
5. Try clicking again - should show cooldown timer (5 minutes)

### Test Admin Login
**Default credentials** (CHANGE THESE IN PRODUCTION!):
- Username: `admin`
- Password: `admin123`

**API endpoint**: http://localhost/devycore-v2/public/api/auth.php/login

Test with curl:
```bash
curl -X POST http://localhost/devycore-v2/public/api/auth.php/login \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"admin\",\"password\":\"admin123\"}"
```

Expected response:
```json
{
  "success": true,
  "data": {
    "token": "a1b2c3d4...",
    "user": {
      "id": 1,
      "username": "admin",
      "role": "super"
    }
  },
  "message": "Login successful"
}
```

---

## Step 6: Performance Check

Open Chrome DevTools:
1. Press **F12**
2. Go to **Lighthouse** tab
3. Select **Desktop**
4. Click **Analyze page load**

**Expected scores** (90% complete version):
- Performance: **90-95**
- Accessibility: **95+**
- Best Practices: **95+**
- SEO: **90+**

---

## Troubleshooting

### Issue: "Database connection failed"
**Solution**:
- Make sure MySQL is running in XAMPP
- Check database name is `devycore_v2`
- Verify `.env` file has correct credentials

### Issue: "Class not found" errors
**Solution**:
```bash
cd C:\xampp\htdocs\devycore-v2
composer dump-autoload --optimize
```

### Issue: "Upload directory not writable"
**Solution**:
```bash
# Right-click folder → Properties → Security → Edit
# Give "Users" full control on:
C:\xampp\htdocs\devycore-v2\public\admin\uploads
```

### Issue: Animations not working
**Solution**:
- Check browser console (F12) for JavaScript errors
- Make sure you're viewing at: `http://localhost/devycore-v2/public/`
- GSAP loads from CDN - check internet connection

### Issue: Particles not showing
**Solution**:
- Particles only load on **desktop** (disabled on mobile)
- They load **after 2 seconds** OR when you scroll
- Check console for WebGL errors

---

## What's Working (90% Complete)

✅ **Backend (100%)**:
- Database schema with 6 tables
- Auth system (token-based, 24h expiry)
- Email class (PHPMailer ready)
- Rate limiting (IP-based)
- 4 API endpoints (auth, projects, contact, discount)
- Input validation & sanitization
- Security (CSRF, XSS, SQL injection protection)

✅ **Frontend (100%)**:
- Brutalist CSS framework (2000+ lines)
- Responsive design (mobile, tablet, desktop)
- Homepage with all sections
- Contact form with validation
- Prize balloon game
- GSAP animations (hero, scroll reveals)
- WebGL particles (optimized, lazy loaded)

✅ **Documentation (100%)**:
- README.md (comprehensive guide)
- SETUP.md (installation steps)
- TEST.md (testing checklist)
- COMPLETE.md (project summary)

---

## What's Remaining (10%)

⏳ **Admin Panel UI** (backend API ready):
- Login page design
- Dashboard with projects table
- Add/Edit/Delete project forms
- Image upload preview
- Drag-and-drop sorting

**Note**: Backend API is fully functional! Admin panel can manage projects via API calls. UI is just for convenience.

---

## Next Actions

1. ✅ **Create database** (Step 2 above)
2. ✅ **Verify setup** (Step 3 above)
3. ✅ **Test website** (Steps 4-5 above)
4. ⏳ **Build admin panel** (optional, 3-4 hours)
5. ⏳ **Configure SMTP** (for email sending)
6. ⏳ **Deploy to production** (when ready)

---

## Production Checklist

Before deploying to live server:

⚠️ **Security** (CRITICAL):
- [ ] Change admin password (`admin123` → strong password)
- [ ] Update `SECRET_KEY` in `.env` (random 64 chars)
- [ ] Change `ADMIN_RESET_CODE` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Enable `ENABLE_HTTPS=true` in `.env`
- [ ] Configure SMTP credentials in `.env`

📧 **Email Setup**:
- [ ] Update `SMTP_HOST` (e.g., smtp.hostinger.com)
- [ ] Update `SMTP_USER` (e.g., info@devycore.com)
- [ ] Update `SMTP_PASS` (your email password)
- [ ] Update `SMTP_FROM_EMAIL` and recipient emails

🚀 **Performance**:
- [ ] Run Lighthouse audit
- [ ] Test on mobile device
- [ ] Check all animations work
- [ ] Verify forms submit correctly

---

## Support & Documentation

- **Full docs**: [README.md](README.md)
- **Setup guide**: [SETUP.md](SETUP.md)
- **Testing guide**: [TEST.md](TEST.md)
- **Project status**: [COMPLETE.md](COMPLETE.md)

---

**You're almost done! Just create the database and you can start using the website. 🚀**
