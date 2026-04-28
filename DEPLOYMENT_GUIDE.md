# Patel Perfumes - Production Deployment Guide

## ZERO TO LIVE IN 5 MINUTES

Your complete, production-ready e-commerce platform is ready. Here's how to get it live anywhere.

---

## Quick Start (Easiest Way)

### 1. Start Local Server
```bash
cd v0-project
php -S localhost:8000 -t public
```

### 2. Visit Setup Page
Open browser: `http://localhost:8000`

The system will automatically redirect to the setup wizard if database doesn't exist.

### 3. Follow Setup Steps
- Click "Start Setup"
- Configure database (auto-creates SQLite)
- Configure Email (optional - Gmail SMTP is FREE)
- Configure SMS/WhatsApp/Telegram (optional)
- Configure AI (optional)
- Click "Complete Setup"

**That's it! Your store is LIVE and ready to sell.**

---

## Web-Based Setup Interface

The setup wizard is beautiful, easy, and requires zero technical knowledge.

### Access Setup Page
```
http://your-domain.com/setup
```

### What Setup Does Automatically
1. Creates SQLite database
2. Runs all database migrations
3. Creates 4 product categories
4. Adds 6 sample perfumes
5. Creates admin user account
6. Configures email settings
7. Configures SMS/WhatsApp/Telegram
8. Configures AI features
9. Creates all necessary tables
10. Seeds sample data

### Setup Wizard Steps

**Step 1: Database Configuration**
- Automatically detects SQLite
- Creates database file
- Runs all migrations
- Creates tables

**Step 2: Email Configuration**
- SMTP settings (Gmail, SendGrid, Mailgun)
- Test email sending
- Configure sender address
- Setup transactional templates

**Step 3: SMS Configuration**
- Twilio setup
- AWS SNS setup
- Test SMS sending
- Configure phone numbers

**Step 4: WhatsApp Configuration**
- Meta Business API setup
- WhatsApp phone number
- Business account ID
- Message templates

**Step 5: Telegram Configuration**
- Bot token setup
- Webhook configuration
- Test message sending

**Step 6: AI Configuration**
- OpenAI API key
- Groq API key
- HuggingFace key
- Choose preferred AI model

**Step 7: Review & Complete**
- Review all settings
- Test each integration
- Create admin user
- Access your store

---

## Production Deployment

### On Your Server

```bash
# 1. Clone or upload your project
git clone https://github.com/viralchabhadiya/v0-luxury-perfume-website.git
cd v0-project

# 2. Set proper permissions
chmod -R 755 storage
chmod -R 755 public

# 3. Visit setup page
http://your-domain.com/setup

# 4. Complete setup wizard
# All configuration done via UI - no command line needed!

# 5. Your store is LIVE!
```

### On Shared Hosting (cPanel, Plesk, etc.)

1. Upload files to `public_html` or your domain folder
2. Set permissions on storage folders (755)
3. Visit `http://yourdomain.com/setup`
4. Complete setup wizard through browser
5. Done!

### On Docker

```dockerfile
FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN chmod -R 755 storage public

EXPOSE 80

CMD ["apache2-foreground"]
```

Then run setup via web browser.

### On Vercel

```bash
# Deploy to Vercel
vercel deploy
```

Then visit `https://your-project.vercel.app/setup`

---

## Database Migrations

All migrations are automatic and production-ready.

### Tables Created
```sql
users              -- Admin users
categories         -- Product categories
products           -- Product catalog
orders             -- Customer orders
order_items        -- Order line items
notifications      -- System notifications
communication_logs -- Email/SMS/WhatsApp logs
ai_recommendations -- AI recommendation history
settings           -- Configuration storage
```

### Automatic Database Creation
The setup wizard automatically:
- Creates SQLite database file
- Runs all migrations
- Creates all tables with proper indexes
- Seeds sample data
- Creates admin user

---

## Configuration Files

All configuration is managed through:

### Environment Variables (.env)
```bash
# Email
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password

# SMS
TWILIO_ACCOUNT_SID=your-sid
TWILIO_AUTH_TOKEN=your-token
TWILIO_PHONE_NUMBER=+1234567890

# WhatsApp
WHATSAPP_ACCESS_TOKEN=your-token
WHATSAPP_PHONE_NUMBER_ID=your-id

# Telegram
TELEGRAM_BOT_TOKEN=your-token

# AI
OPENAI_API_KEY=your-key
GROQ_API_KEY=your-key
```

### Admin Configuration Panel
Instead of editing .env, use:
```
http://your-domain.com/admin/settings
```

All settings can be configured through the beautiful admin dashboard.

---

## Email Configuration

### FREE Options

**Gmail (Recommended)**
1. Go to `https://myaccount.google.com/apppasswords`
2. Select Mail → Windows
3. Copy app password
4. In setup wizard, paste the password
5. Done! Free unlimited emails

**SendGrid (Free tier)**
1. Sign up at `sendgrid.com`
2. Get API key
3. Paste in setup wizard
4. Free 100 emails/day

### Paid Options (Optional)

**AWS SES**
- $0.10 per 1000 emails
- Very reliable

**Mailgun**
- 100 free emails/month
- Then $0.50 per 1000

---

## SMS Configuration

### Twilio (Recommended)
```
Cost: $0.01 - $0.10 per SMS
Free trial: $15 credit
Setup: 2 minutes
```

1. Sign up at `twilio.com`
2. Get Account SID and Auth Token
3. Get Twilio phone number
4. Paste in setup wizard
5. Done!

### AWS SNS
```
Cost: $0.00645 per SMS to USA
Setup: 5 minutes
```

---

## WhatsApp Business API

### Meta WhatsApp Integration
```
Cost: $0.0435 per message (India)
Setup: 15 minutes
```

1. Create Meta Business Account
2. Apply for WhatsApp Business API
3. Get Phone Number ID and Access Token
4. Paste in setup wizard
5. Done!

---

## Telegram Bot

### FREE Telegram Integration
```
Cost: COMPLETELY FREE
Messages: UNLIMITED
Setup: 2 minutes
```

1. Message @BotFather on Telegram
2. Create new bot
3. Get bot token
4. Paste in setup wizard
5. Done!

---

## AI Configuration

### Options

**OpenAI GPT-4 (Most Powerful)**
```
Cost: $0.03 per 1K tokens (~$1-10/month)
Models: gpt-4, gpt-4-turbo, gpt-3.5-turbo
Setup: 2 minutes
```

**Groq (Fast & Cheap)**
```
Cost: $0.50 per million tokens (~$0.05/month)
Models: mixtral-8x7b, gemma-7b
Setup: 2 minutes
Fastest inference: 100+ tokens/second
```

**HuggingFace (Open Source)**
```
Cost: FREE
Models: Open source models
Setup: 5 minutes
Privacy: Data stays on your server
```

---

## Security Checklist

- [ ] Change admin password after setup
- [ ] Enable HTTPS on your domain
- [ ] Set strong database password
- [ ] Keep API keys secure (never commit to git)
- [ ] Regular database backups
- [ ] Monitor error logs
- [ ] Update PHP version to 8.2+

---

## Troubleshooting

### Setup Page Not Loading
```bash
# Check PHP version
php -v  # Should be 7.4+

# Check permissions
chmod -R 755 storage

# Check if database exists
ls -la database/
```

### Email Not Sending
1. Check SMTP credentials in setup
2. Enable "Less secure apps" for Gmail
3. Create app-specific password
4. Test email in admin panel

### Database Locked
```bash
# SQLite is single-user
# Make sure only one connection at a time

# Restart PHP server
php -S localhost:8000 -t public
```

### Permission Denied
```bash
# Fix storage permissions
chmod -R 755 storage
chmod -R 755 public
chown -R www-data:www-data storage
```

---

## Scaling

### Local Development
- Works on your laptop
- No server needed
- Perfect for testing

### Shared Hosting
- Upload files via FTP
- Run setup via browser
- Live immediately

### VPS/Cloud Server
- SSH into server
- Clone repository
- Run setup via browser
- Live immediately

### Load Balancing
- Use Redis for sessions
- Configure in setup
- Multiple servers
- Automatic scaling

---

## Backup & Restore

### Backup Database
```bash
# SQLite - just copy the file
cp database/patel_perfumes.db database/patel_perfumes.db.backup

# Or compress
tar -czf backup.tar.gz database/
```

### Backup Everything
```bash
tar -czf patel-perfumes-backup.tar.gz .
```

### Restore
```bash
# Extract backup
tar -xzf patel-perfumes-backup.tar.gz

# Restore database
cp database/patel_perfumes.db.backup database/patel_perfumes.db
```

---

## Performance Optimization

### Caching
- Enable browser caching
- Use Redis for sessions
- Cache API responses

### Database
- Index frequently queried columns
- Regular VACUUM for SQLite
- Monitor query performance

### Assets
- Use CDN for images
- Minify CSS/JS
- Enable gzip compression

---

## Support & Documentation

All documentation is included in the package:

- **SETUP_GUIDE.md** - Complete setup instructions
- **FEATURES_2026.md** - All features explained
- **ARCHITECTURE.md** - Technical documentation
- **README.md** - Project overview
- **DEPLOYMENT_GUIDE.md** - This file

---

## Getting Help

### Common Issues

**Q: Setup page is blank**
A: Clear browser cache (Ctrl+Shift+Delete) and refresh

**Q: Database already exists**
A: Delete `database/patel_perfumes.db` to reset

**Q: Email not sending**
A: Check SMTP credentials in admin panel

**Q: Can't connect to Twilio**
A: Verify API credentials are correct

---

## You're Ready!

Your complete e-commerce platform is production-ready.

1. Download the ZIP
2. Extract it
3. Visit `/setup`
4. Follow the wizard
5. Start selling!

**No coding, no command line, no technical knowledge needed.**

Everything is automated and intuitive.

---

**Enjoy your Patel Perfumes store!** 🧴✨
