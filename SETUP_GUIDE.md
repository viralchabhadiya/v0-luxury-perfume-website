# Patel Perfumes - Complete Setup Guide

## Quick Start (2 Minutes)

### Prerequisites
- PHP 7.4+ with PDO SQLite
- Command line access (Terminal/CMD)

### Step 1: Start the Server
```bash
cd /path/to/patel-perfumes
php -S localhost:8000 -t public
```

### Step 2: Open Setup Wizard
Navigate to: **http://localhost:8000/setup**

### Step 3: Complete Setup Wizard
The web-based setup wizard will guide you through:
1. Database initialization
2. Application settings
3. Admin account creation
4. Email configuration
5. SMS/WhatsApp setup (optional)
6. AI configuration (optional)

### Step 4: Access Your Store
- **Store:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin/login

That's it! Your store is live with sample data.

---

## Setup Wizard Guide

### Step 1: Database Setup
- Automatically creates SQLite database
- Creates all necessary tables
- No manual configuration needed
- Progress: ✓ Automatic

### Step 2: Application Settings
**Configure your store name and URL:**
- **Application Name:** Name of your store (e.g., "Patel Perfumes")
- **Application URL:** Where your store will run (e.g., "http://localhost:8000")
- **Admin Email:** Email for admin account

### Step 3: Admin Account
**Create your admin user:**
- **Username:** For login
- **Password:** Create a strong password
- **Full Name:** Your name

### Step 4: Email Configuration
**Setup transactional emails:**

#### Option A: Testing Only
- Select: "Log (Testing - No Emails Sent)"
- Perfect for development
- Emails saved to logs

#### Option B: Gmail SMTP (FREE)
1. Select: "SMTP"
2. Host: `smtp.gmail.com`
3. Port: `587`
4. Email: Your Gmail address
5. Password: [Gmail App Password](https://support.google.com/accounts/answer/185833)

#### Option C: SendGrid (Free tier available)
1. Select: "SendGrid API"
2. Get API key from sendgrid.com
3. Free tier: 100 emails/day

### Step 5: SMS & WhatsApp (Optional)

#### SMS with Twilio
1. Sign up at twilio.com
2. Get your credentials
3. Enter: SID, Auth Token, Phone Number
4. Cost: $0.0075 per SMS (approximate)

#### WhatsApp Business API (Meta)
1. Sign up at business.facebook.com
2. Get Phone Number ID and Access Token
3. Cost: ₹1-2 per message (approximate)

### Step 6: AI Features (Optional)

#### OpenAI GPT-4
1. Sign up at openai.com
2. Get API key
3. Cost: Pay per token (usually ₹200-500/month for moderate use)

#### Groq AI (Recommended - Fast & Affordable)
1. Sign up at console.groq.com
2. Get API key
3. Cost: ₹50-100/month (very affordable)
4. Speed: 10-100x faster than GPT-4

#### HuggingFace
1. Sign up at huggingface.co
2. Get API key
3. Cost: Free tier available

### Step 7: Review
- Review all your settings
- Click "Complete Setup"
- Wait for database initialization
- Success! Navigate to your store

---

## Manual Setup (Advanced)

If the wizard doesn't work, you can setup manually:

### 1. Create Database Directory
```bash
mkdir -p database
```

### 2. Initialize Database
```bash
php -r "
require 'setup-api.php';
"
```

### 3. Update .env
```bash
cp .env.example .env
# Edit .env with your configuration
```

### 4. Configure Services
Update these in `.env`:
```
MAIL_DRIVER=log
TWILIO_ENABLED=false
WHATSAPP_ENABLED=false
AI_PROVIDER=openai
```

---

## Troubleshooting

### Issue: Setup page doesn't load
**Solution:**
1. Check if PHP is running: `php -S localhost:8000 -t public`
2. Clear browser cache
3. Try: http://localhost:8000/setup

### Issue: Database error
**Solution:**
1. Ensure write permissions: `chmod -R 755 database/`
2. Delete old database: `rm database/patel_perfumes.db`
3. Start fresh setup

### Issue: Email not working
**Solution:**
1. Check credentials in Admin → Settings → Email
2. Verify SMTP host and port
3. Check app password (not Gmail password)
4. Review email logs in Admin → Settings → Logs

### Issue: Can't login to admin
**Solution:**
1. Check admin credentials: Email set during setup
2. Password: The one you created
3. Reset: Delete `database/patel_perfumes.db` and redo setup

---

## File Structure

```
patel-perfumes/
├── public/              # Webroot
│   ├── index.php       # Main entry point
│   ├── css/            # Stylesheets
│   └── js/             # JavaScript
├── app/                # Application code
│   ├── Http/Controllers/
│   ├── Models/
│   └── Services/
├── resources/          # Views (Blade templates)
│   ├── views/
│   └── css/
├── database/           # SQLite database
│   └── patel_perfumes.db
├── config/             # Configuration files
├── routes/             # Route definitions
├── setup-web.php       # Setup UI
├── setup-api.php       # Setup API
├── bootstrap.php       # App bootstrap
└── .env                # Environment variables
```

---

## Database Structure

### Tables Created

1. **users** - Admin and customer accounts
2. **categories** - Product categories
3. **products** - Perfume listings
4. **orders** - Customer orders
5. **order_items** - Items in orders
6. **notifications** - System notifications
7. **communication_logs** - Email/SMS/WhatsApp logs
8. **ai_recommendations** - AI product suggestions
9. **settings** - Application settings

### Sample Data Seeded

**Categories:** Men, Women, Unisex, Limited Edition
**Products:** 6 sample perfumes with full details

---

## Environment Variables

### Essential
```
APP_NAME=Patel Perfumes
APP_URL=http://localhost:8000
DB_PATH=database/patel_perfumes.db
```

### Email
```
MAIL_DRIVER=log|smtp|sendgrid
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
```

### SMS (Twilio)
```
TWILIO_ENABLED=true|false
TWILIO_ACCOUNT_SID=...
TWILIO_AUTH_TOKEN=...
TWILIO_PHONE_NUMBER=+1234567890
```

### WhatsApp (Meta)
```
WHATSAPP_ENABLED=true|false
WHATSAPP_PHONE_NUMBER_ID=...
WHATSAPP_ACCESS_TOKEN=...
```

### AI
```
AI_PROVIDER=openai|groq|huggingface
OPENAI_API_KEY=...
GROQ_API_KEY=...
OPENAI_ENABLED=true|false
```

---

## Admin Dashboard

Once setup is complete:

1. **Go to:** http://localhost:8000/admin/login
2. **Login with:**
   - Email: The email you entered during setup
   - Password: The password you created
3. **Access:**
   - Products Management
   - Category Management
   - Order Management
   - Settings Configuration
   - Communication Logs
   - Email Configuration
   - SMS Configuration
   - WhatsApp Configuration
   - AI Configuration

---

## Production Deployment

### Before Going Live

1. **Update .env:**
   ```
   APP_URL=https://yourdomain.com
   ```

2. **Configure Email:**
   - Use SendGrid or similar service
   - Update MAIL_DRIVER and credentials

3. **Setup SSL:**
   - Enable HTTPS on your server

4. **Backup Database:**
   - Regularly backup `database/patel_perfumes.db`

5. **Security:**
   - Change admin password
   - Set strong random password
   - Enable 2FA if available

### Recommended Hosting
- Any host with PHP 7.4+
- Support for SQLite (included in PHP)
- SSH access for backups
- Recommended: ₹100-300/month hosting

---

## Support & Resources

### Setup Issues
1. Check logs: `database/logs/`
2. Read error messages carefully
3. Check .env syntax
4. Verify credentials

### API Documentation
- Email Service: `app/Services/EmailService.php`
- Messaging Service: `app/Services/MessagingService.php`
- AI Service: `app/Services/AIService.php`

### Need Help?
- Check documentation files
- Review sample code in controllers
- Check configuration files for examples

---

## Next Steps

1. ✓ Complete setup
2. Add your branding
3. Configure email service
4. Setup payment gateway
5. Create product images
6. Add more products
7. Test checkout flow
8. Deploy to production

Happy Selling! 🧴✨
