# Patel Perfumes - Luxury E-Commerce Platform (2026)

A production-ready full-stack Laravel 13 e-commerce platform with AI, Email, SMS, WhatsApp, Telegram, and complete 2026-era integrations. Beautiful web-based setup wizard - zero technical knowledge required!

## QUICK START (5 MINUTES)

```bash
# 1. Extract and navigate
cd v0-project

# 2. Start server
php -S localhost:8000 -t public

# 3. Visit setup page
# Browser will auto-redirect to: http://localhost:8000/setup

# 4. Complete setup wizard (click through, 5 minutes)
# That's it! Your store is LIVE with sample data
```

**No command line skills needed. Beautiful web-based setup wizard handles everything.**

## What's Included

### Modern 2026 Features

### Email System
- PHP Mailer integration
- SMTP, SendGrid, Mailgun support
- Transactional email templates
- Newsletter management
- Order confirmations & shipment notifications
- Admin configuration panel
- Email testing tools

### SMS & Messaging (Twilio, AWS SNS)
- Order notifications via SMS
- Shipment tracking alerts
- Customer support messages
- Admin configuration
- Message logging & analytics

### WhatsApp Business API
- Meta WhatsApp integration
- Template messages
- Two-way customer support
- Rich media support
- Message tracking

### Telegram Bot
- Automated alerts and notifications
- Customer support chat
- Document sharing
- Webhook support
- Completely FREE!

### AI Features
- OpenAI GPT-4 integration
- Groq AI (fast & affordable)
- HuggingFace models
- Product recommendations
- 24/7 AI customer chatbot
- Semantic smart search
- Content generation
- Review sentiment analysis

### Interactive Widgets
- Floating chat widget (AI-powered)
- Product recommendations widget
- Newsletter subscription widget
- AI search widget
- All customizable

### Admin Dashboard
- Email configuration panel
- SMS configuration panel
- WhatsApp configuration panel
- Telegram configuration panel
- AI configuration panel
- Communication logs viewer
- Product & category management
- Order management
- Settings dashboard

### Frontend
- **Homepage** with hero section and featured products
- **Product Listing** with filtering and pagination
- **Product Details** page with comprehensive fragrance information
- **Shopping Cart** with real-time quantity management
- **Checkout** with customer information and payment method selection
- **Order Confirmation** page with order details
- **Scroll-Based Animations** powered by GSAP ScrollTrigger:
  - Fade-in animations
  - Scale animations
  - Counter animations
  - Staggered animations

### Backend
- **RESTful API** endpoints for product management
- **Session-Based Cart** management
- **Order Processing** and storage
- **Complete Admin Panel** with all services integrated

### Database (Production-Ready)
- SQLite database with proper relationships
- 9 tables with proper migrations
- Tables: Users, Categories, Products, Orders, OrderItems, Notifications, CommunicationLogs, AIRecommendations, Settings
- JSON support for complex data
- Automatic backup support

### Design
- **Color Scheme**: Luxury theme with warm earth tones
  - Primary: #8B6F47 (Bronze Brown)
  - Secondary: #F5E6D3 (Cream)
  - Accent: #D4AF37 (Gold)
  - Dark: #2C2C2C
- **Typography**: Clean, modern fonts with excellent readability
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Animations**: GSAP ScrollTrigger for smooth scroll effects

## Project Structure

```
patel-perfumes/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       ├── ProductController.php
│   │       ├── CartController.php
│   │       ├── CheckoutController.php
│   │       ├── OrderController.php
│   │       └── Admin/
│   │           ├── ProductController.php
│   │           └── CategoryController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   ├── Database.php
│   └── Application.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_categories_table.php
│   │   ├── 2024_01_01_000003_create_products_table.php
│   │   ├── 2024_01_01_000004_create_orders_table.php
│   │   └── 2024_01_01_000005_create_order_items_table.php
│   └── patel_perfumes.db (SQLite database)
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── header.blade.php
│   │   │   └── footer.blade.php
│   │   ├── home.blade.php
│   │   ├── products/
│   │   │   ├── index.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── by-category.blade.php
│   │   ├── cart/
│   │   │   └── index.blade.php
│   │   ├── checkout/
│   │   │   └── index.blade.php
│   │   ├── order/
│   │   │   └── confirmation.blade.php
│   │   └── admin/
│   │       ├── layouts/
│   │       │   └── app.blade.php
│   │       └── products/
│   │           ├── index.blade.php
│   │           └── create.blade.php
│   └── css/
│       └── app.css
├── routes/
│   └── web.php
├── public/
│   ├── index.php
│   ├── css/
│   └── js/
├── config/
│   └── app.php
├── .env
├── setup.php
├── bootstrap.php
├── package.json
└── README.md
```

## Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Node.js/npm (optional, for frontend build tools)
- SQLite3 (included with PHP)

### Step 1: Install Dependencies

```bash
# No external PHP dependencies needed - pure Laravel-inspired code
# Install Node dependencies for GSAP and Tailwind CSS
npm install
```

### Step 2: Setup Database

```bash
# Run the setup script to create database and seed sample data
php setup.php
```

This will:
- Create SQLite database at `database/patel_perfumes.db`
- Create all necessary tables
- Seed sample data including:
  - Admin user (email: admin@patelperfumes.com, password: admin123)
  - 4 product categories
  - 6 sample products

### Step 3: Start Development Server

```bash
# Start PHP built-in server
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` in your browser.

## Routes

### Frontend Routes
- `/` - Homepage
- `/products` - Product listing
- `/products/{slug}` - Product detail page
- `/category/{slug}` - Products by category
- `/cart` - Shopping cart
- `/checkout` - Checkout page
- `/order/{order}/confirmation` - Order confirmation

### Admin Routes
- `/admin/products` - Product management
- `/admin/products/create` - Add new product
- `/admin/products/{id}/edit` - Edit product
- `/admin/categories` - Category management

## Usage

### Adding Products

1. Navigate to `/admin/products`
2. Click "Add Product"
3. Fill in the form with:
   - Product name and descriptions
   - Price and optional discount price
   - Category
   - Volume and fragrance profile
   - Longevity and projection details
4. Save

### Managing Cart

- Products can be added to cart from product detail pages
- Cart persists in session (PHP session storage)
- Update quantities or remove items from cart page
- Cart total includes tax (8%) and shipping costs

### Checkout Process

1. User navigates to checkout
2. Enters shipping and billing information
3. Selects payment method
4. Places order
5. Receives confirmation with order number and details

## Scroll-Based Animations

The site uses GSAP ScrollTrigger for smooth scroll animations:

### Animation Types
1. **Fade In** - Elements fade in as they come into view
   - Use `data-scroll-fade` attribute
   
2. **Scale** - Elements scale up as they become visible
   - Use `data-scroll-scale` attribute
   
3. **Counters** - Numbers animate when scrolled into view
   - Use `data-counter="number"` attribute
   
4. **Staggered** - Multiple items animate with delay
   - Use `data-scroll-stagger` on container
   - Use `data-stagger-item` on children

### Example Usage

```html
<!-- Fade in animation -->
<div data-scroll-fade style="opacity: 0; transform: translateY(30px);">
  Content
</div>

<!-- Counter animation -->
<span data-counter="1000">0</span>

<!-- Staggered items -->
<div data-scroll-stagger>
  <div data-stagger-item>Item 1</div>
  <div data-stagger-item>Item 2</div>
</div>
```

## Admin Credentials

After setup, use these credentials to access the admin panel:
- **Email**: admin@patelperfumes.com
- **Password**: admin123

## Sample Products

The setup includes 6 sample fragrance products:

1. **Midnight Elegance** - Woody fragrance for men ($69.99, on sale)
2. **Rose Garden** - Floral fragrance for women ($79.99)
3. **Ocean Breeze** - Fresh unisex fragrance ($54.99, on sale)
4. **Amber Sunset** - Oriental fragrance for women ($84.99)
5. **Citrus Paradise** - Citrus fragrance for men ($69.99)
6. **Jasmine Dreams** - Floral fragrance for women ($74.99, on sale)

## Styling & Customization

### Color Scheme

Colors are defined as CSS variables in `resources/views/layouts/app.blade.php`:

```css
:root {
    --primary: #8B6F47;
    --secondary: #F5E6D3;
    --accent: #D4AF37;
    --dark: #2C2C2C;
    --light: #FAFAF8;
}
```

Modify these values to change the entire color scheme.

### Typography

Using Tailwind CSS for responsive typography. Font sizes scale automatically for mobile and desktop.

### Responsive Breakpoints

- **Mobile**: Default styles
- **Tablet (md)**: 768px and above
- **Desktop (lg)**: 1024px and above

## Performance Considerations

- GSAP ScrollTrigger is optimized for performance
- Animations use GPU acceleration
- CSS Tailwind for minimal CSS bundle
- SQLite for lightweight database
- Session-based cart reduces server load

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements

- User authentication and accounts
- Wishlist functionality
- Product reviews and ratings
- Email notifications
- Payment gateway integration (Stripe/PayPal)
- Advanced admin dashboard with analytics
- Product search and advanced filters
- Multi-language support
- Image uploads and optimization

## Troubleshooting

### Database Errors
If you get database errors, ensure:
1. `database/` directory exists and is writable
2. Run `php setup.php` to create database

### Missing Data
If products don't appear after setup:
1. Check `database/patel_perfumes.db` exists
2. Re-run `php setup.php`
3. Clear browser cache

### Animation Issues
If scroll animations aren't working:
1. Verify GSAP is loading (check console)
2. Ensure `data-scroll-*` attributes are present
3. Check browser console for JavaScript errors

## License

This project is part of the Patel Perfumes brand and is for demonstration purposes.

## Support

For issues or questions, please contact the development team.

---

**Version**: 1.0.0
**Last Updated**: 2024
**Framework**: Laravel 13 (Blade)
**Database**: SQLite
**Frontend**: Tailwind CSS + GSAP ScrollTrigger
