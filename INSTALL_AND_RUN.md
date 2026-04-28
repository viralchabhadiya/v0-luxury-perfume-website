# Install & Run - Patel Perfumes

## The Simplest Way Possible

### Option 1: Mac/Linux/Windows (Easiest)

#### Step 1: Extract the ZIP
```bash
unzip patel-perfumes-2026-complete.zip
cd v0-project
```

#### Step 2: Start Server
```bash
php -S localhost:8000 -t public
```

#### Step 3: Open Browser
```
http://localhost:8000
```

**System will auto-redirect to setup page**

#### Step 4: Click Through Setup
- Click "Start Setup"
- Click "Create Database" 
- Click "Configure Email" (optional, can skip)
- Click "Configure SMS" (optional, can skip)
- Click "Complete Setup"
- Click "Go to Store"

**Your store is LIVE!**

---

## That's It!

### Access Points
- **Customer Store**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Setup Page**: http://localhost:8000/setup (auto-loads first time)

### Sample Data
- **Admin Email**: admin@patelperfumes.com
- **Admin Password**: admin123
- **Sample Products**: 6 perfumes pre-loaded
- **Sample Categories**: 4 categories ready

---

## Requirements

- **PHP**: 7.4+ (8.0+ recommended)
- **Database**: SQLite (auto-creates)
- **Server**: Any (local, VPS, shared hosting)

### Check PHP Version
```bash
php -v
```

Should show PHP 7.4 or higher.

---

## On Different Systems

### Windows Users
1. Install PHP: https://windows.php.net/download/
2. Extract Patel Perfumes ZIP
3. Open Command Prompt in folder
4. Run: `php -S localhost:8000 -t public`
5. Open: http://localhost:8000

### Mac Users
1. macOS includes PHP
2. Extract Patel Perfumes ZIP
3. Open Terminal in folder
4. Run: `php -S localhost:8000 -t public`
5. Open: http://localhost:8000

### Linux Users
```bash
# Ubuntu/Debian
sudo apt install php php-sqlite3

# Extract and run
cd v0-project
php -S localhost:8000 -t public
```

---

## Upload to Your Server

### Via FTP/SFTP
1. Extract ZIP on your computer
2. Connect to server via FTP
3. Upload entire `v0-project` folder
4. Visit: `http://yourdomain.com/setup`
5. Complete setup wizard

### Via SSH (VPS/Cloud)
```bash
# SSH into server
ssh user@your-domain.com

# Navigate to public_html
cd public_html

# Clone from GitHub (optional)
git clone https://github.com/viralchabhadiya/v0-luxury-perfume-website.git
cd v0-luxury-perfume-website

# Set permissions
chmod -R 755 storage

# Visit setup
# http://yourdomain.com/setup
```

### Via cPanel
1. Go to File Manager
2. Navigate to public_html
3. Upload ZIP file
4. Extract ZIP
5. Visit: http://yourdomain.com/setup
6. Done!

---

## Production Setup

### Step 1: Upload Files
Use FTP, SFTP, or SSH to upload the project

### Step 2: Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 public
```

### Step 3: Visit Setup Page
```
http://yourdomain.com/setup
```

### Step 4: Complete Setup Wizard
- Configure database (auto-creates)
- Configure email (Gmail SMTP = FREE)
- Optional: Configure SMS/WhatsApp/Telegram
- Optional: Configure AI
- Click "Complete Setup"

### Step 5: Change Admin Password
1. Go to: http://yourdomain.com/admin
2. Login with: admin@patelperfumes.com / admin123
3. Change password immediately

### Step 6: Your Store is LIVE!

---

## Verify Installation

### Check Setup Worked
Visit: `http://localhost:8000` (or your domain)

You should see:
- Beautiful homepage with perfume image
- "Shop Now" button
- Featured products
- Professional design

### Test Admin Panel
Visit: `http://localhost:8000/admin`
- Login with: admin@patelperfumes.com / admin123
- You should see admin dashboard

### Test Store
1. Click "Shop Now"
2. Browse products
3. Click on a product
4. Add to cart
5. Proceed to checkout
6. Everything works!

---

## Troubleshooting

### Problem: "Page not found" or blank page
**Solution**: 
1. Make sure PHP is running: `php -S localhost:8000 -t public`
2. Check URL: http://localhost:8000 (with port 8000)
3. Clear browser cache (Ctrl+Shift+Delete)

### Problem: "Permission denied" error
**Solution**:
```bash
chmod -R 755 storage
chmod -R 755 public
```

### Problem: Database errors
**Solution**:
1. Delete `database/patel_perfumes.db` if it exists
2. Visit http://localhost:8000/setup again
3. Let setup create fresh database

### Problem: Setup page shows blank
**Solution**:
1. Update PHP to 7.4+
2. Enable SQLite extension: `php -m | grep sqlite`
3. Restart PHP server

### Problem: Email test fails
**Solution**:
1. Check SMTP credentials in setup
2. For Gmail: Use app-specific password (not regular password)
3. Enable "Less secure apps" on Gmail account
4. Try sending test email again

---

## Email Setup (For Order Notifications)

### Gmail (FREE - Recommended)
1. Go to: https://myaccount.google.com/apppasswords
2. Select Mail and Windows
3. Google gives you a password
4. Paste that password in setup wizard
5. Done! Unlimited free emails

### SendGrid (100 free/day)
1. Sign up: sendgrid.com
2. Get API key
3. Paste in setup wizard
4. Done!

### Mailgun (100 free/month)
1. Sign up: mailgun.com
2. Get API key
3. Paste in setup wizard
4. Done!

---

## What's Next?

### Customize Your Store
1. Edit product images in `public/images/`
2. Edit product names/descriptions in admin panel
3. Change colors in CSS
4. Add your own perfume products

### Enable SMS Alerts (Optional)
1. Sign up for Twilio: twilio.com (gets $15 free credit)
2. Get API credentials
3. Paste in admin Settings
4. Done! SMS notifications active

### Enable WhatsApp (Optional)
1. Setup Meta Business Account
2. Get WhatsApp Business API access
3. Paste credentials in admin Settings
4. Done! WhatsApp support active

### Enable AI Chat (Optional)
1. Get OpenAI API key: openai.com
2. Paste in admin Settings
3. Done! AI chatbot active

---

## Security Checklist

After setup:
- [ ] Change admin password
- [ ] Enable HTTPS on domain
- [ ] Update .env file with real API keys
- [ ] Setup regular backups
- [ ] Monitor logs

---

## You're All Set!

Your Patel Perfumes store is ready to serve customers.

**Start selling in 5 minutes. No coding, no technical setup.**

Need help? Check DEPLOYMENT_GUIDE.md or FEATURES_2026.md

Happy selling! 🧴✨
