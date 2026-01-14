# Devycore V2 - Quick Setup Guide

## 🚀 Quick Start (XAMPP)

### 1. Install Dependencies

```bash
cd c:\xampp\htdocs\devycore-v2
composer install
```

If you don't have Composer:
- Download from: https://getcomposer.org/download/
- Install globally
- Restart terminal

### 2. Create Database

Open phpMyAdmin: http://localhost/phpmyadmin

```sql
CREATE DATABASE devycore_v2;
```

Then import schema:
- Go to devycore_v2 database
- Click "Import"
- Choose file: `database/schema.sql`
- Click "Go"

### 3. Configure Environment

The `.env` file is already created. Just update these if needed:
- `DB_PASS` (if you have MySQL password)
- SMTP settings (if you want email to work)

### 4. Create Uploads Directory

```bash
mkdir public\admin\uploads
```

Or manually create folder: `c:\xampp\htdocs\devycore-v2\public\admin\uploads`

### 5. Start Apache & MySQL

Open XAMPP Control Panel:
- Start Apache
- Start MySQL

### 6. Access Website

**Frontend**: http://localhost/devycore-v2/public/

**Admin** (coming soon): http://localhost/devycore-v2/public/admin/login.php

**Default Login**:
- Username: `admin`
- Password: `admin123`

---

## ✅ What's Working

- ✅ Complete PHP backend (Database, Auth, Email, RateLimit)
- ✅ API endpoints (auth, projects, contact, discount)
- ✅ Brutalist CSS framework (base, layout, components, effects)
- ✅ Homepage with responsive design
- ✅ Contact form with API integration
- ✅ MySQL database schema

## 🔄 In Progress

- [ ] GSAP animations
- [ ] WebGL particles (Three.js)
- [ ] Prize balloon game
- [ ] Admin panel UI
- [ ] Project detail pages

---

## 🧪 Testing APIs

### Test Contact Form

```bash
curl -X POST http://localhost/devycore-v2/public/api/contact.php \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "phone": "123456789",
    "company": "Test Company",
    "project_type": "Web Application",
    "company_type": "Startup",
    "message": "This is a test message",
    "website": ""
  }'
```

### Test Login

```bash
curl -X POST http://localhost/devycore-v2/public/api/auth.php/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "admin123"
  }'
```

### Test Projects (Public)

```bash
curl http://localhost/devycore-v2/public/api/projects.php
```

---

## 🎨 Design Preview

The homepage showcases:
- **Brutalist Design**: Sharp borders, high contrast, no rounded corners
- **Electric Green (#00ff88)** + **Hot Magenta (#ff0055)** accents
- **Pure Black (#0a0a0a)** background
- **Grid overlay** with 120px spacing
- **Geometric shapes** and bold typography
- **Hover effects** with brutal shadows

---

## 📁 Project Structure

```
devycore-v2/
├── public/
│   ├── index.php              ✅ Homepage
│   ├── api/
│   │   ├── auth.php          ✅ Authentication
│   │   ├── projects.php      ✅ Projects CRUD
│   │   ├── contact.php       ✅ Contact form
│   │   └── discount.php      ✅ Discount form
│   └── assets/css/
│       ├── base.css          ✅ Reset + variables
│       ├── layout.css        ✅ Grid system
│       ├── components.css    ✅ Buttons, cards, forms
│       └── brutalist.css     ✅ Special effects
├── src/
│   ├── classes/              ✅ All backend classes
│   └── utils/                ✅ Helpers + validation
├── database/
│   └── schema.sql            ✅ Complete schema
└── .env                      ✅ Configuration
```

---

## 🐛 Troubleshooting

### "Call to undefined function Devycore\..."
Run: `composer install`

### "Access denied for user 'root'@'localhost'"
Update `.env` with your MySQL password

### "Can't connect to database"
- Check if MySQL is running in XAMPP
- Verify database name is `devycore_v2`

### Contact form doesn't send email
- Email sending requires SMTP configuration
- Update SMTP settings in `.env`
- Or check browser console for success message (email queued)

### CSS not loading
- Make sure Apache is running
- Check if path is correct: `/devycore-v2/public/assets/css/...`
- Clear browser cache

---

## 🎯 Next Steps

1. **Install Composer dependencies** (if not done)
2. **Import database schema**
3. **Test homepage**: http://localhost/devycore-v2/public/
4. **Test contact form submission**
5. **Test API with login**

---

## 📞 Need Help?

- Check `README.md` for full documentation
- Review API endpoints in `public/api/`
- Check PHP error log: `c:\xampp\apache\logs\error.log`

---

**Ready to build something amazing! 🚀**
