# Quick Start Guide - Patel Perfumes

## 🚀 Get Started in 2 Minutes

### Step 1: Setup Database (30 seconds)
```bash
php setup.php
```

This command will:
- ✅ Create SQLite database
- ✅ Create all tables
- ✅ Seed sample products and admin user
- ✅ Generate 6 sample fragrances across multiple categories

### Step 2: Start the Server (10 seconds)
```bash
php -S localhost:8000 -t public
```

### Step 3: Open in Browser (20 seconds)
Visit: **http://localhost:8000**

That's it! You're running! 🎉

---

## 📍 Where to Go

### Customer Experience
- **Home Page**: http://localhost:8000/
- **Shop Products**: http://localhost:8000/products
- **Women's Fragrances**: http://localhost:8000/category/women
- **Men's Fragrances**: http://localhost:8000/category/men
- **Shopping Cart**: http://localhost:8000/cart
- **Checkout**: http://localhost:8000/checkout

### Admin Panel
- **Admin Dashboard**: http://localhost:8000/admin/products
- **Manage Products**: http://localhost:8000/admin/products
- **Manage Categories**: http://localhost:8000/admin/categories
- **Admin Email**: admin@patelperfumes.com
- **Admin Password**: admin123

---

## 🎨 What You Get

### Sample Data (Pre-Loaded)
✅ **4 Categories**: Men, Women, Unisex, Limited Edition
✅ **6 Products**: Complete with descriptions, prices, and fragrance details
✅ **Admin Account**: Ready to use
✅ **Full UI**: All pages styled and animated

### Features
✅ **Scroll Animations**: GSAP ScrollTrigger animations on every page
✅ **Shopping Cart**: Session-based cart management
✅ **Checkout Flow**: Complete order process
✅ **Admin Panel**: Add/edit/delete products and categories
✅ **Responsive Design**: Mobile, tablet, and desktop optimized
✅ **Product Categories**: Browse by category

---

## 🎯 Key Pages to Explore

### 1. Homepage (`/`)
- Hero section with animations
- Featured products grid
- "Why Choose Us" section
- Statistics with animated counters
- Newsletter signup

### 2. Products Page (`/products`)
- Complete product listing
- Category filters
- Pagination
- Price filtering (ready to implement)

### 3. Product Detail (`/products/ocean-breeze`)
- Full product information
- Fragrance profile details (volume, scent type, longevity, projection)
- Add to cart functionality
- Related products
- Image gallery placeholder

### 4. Shopping Cart (`/cart`)
- View all items in cart
- Update quantities
- Remove items
- Order summary
- Proceed to checkout

### 5. Checkout (`/checkout`)
- Customer information form
- Shipping address
- Payment method selection
- Order summary
- Final total with taxes

### 6. Order Confirmation (`/order/[id]/confirmation`)
- Order number and status
- Item details
- Shipping address
- Order total breakdown
- Print receipt button

### 7. Admin Products (`/admin/products`)
- View all products in table
- Edit existing products
- Delete products
- Add new products
- Stock status indicators

---

## 🔧 Making Changes

### Add a New Product

1. Go to Admin: http://localhost:8000/admin/products
2. Click "+ Add Product"
3. Fill in the form:
   - Product name (e.g., "Lavender Dreams")
   - Short description
   - Long description
   - Price and optional discount price
   - Category
   - Volume (e.g., "100ml")
   - Scent profile (e.g., "Floral")
   - Longevity (e.g., "8-10 hours")
   - Projection (e.g., "Strong")
   - Check "In Stock" if available
   - Check "Featured Product" to show on homepage
4. Click "Create Product"

### Edit Homepage Content

Edit `/resources/views/home.blade.php` to change:
- Hero section text and buttons
- Featured products section
- "Why Choose Us" benefits
- Statistics
- Newsletter CTA

### Customize Colors

Edit `/resources/views/layouts/app.blade.php` - Change the CSS variables at the top:
```css
:root {
    --primary: #8B6F47;      /* Main brand color */
    --secondary: #F5E6D3;    /* Light background */
    --accent: #D4AF37;       /* Gold highlights */
    --dark: #2C2C2C;         /* Text color */
    --light: #FAFAF8;        /* Page background */
}
```

---

## 🎬 Understanding Animations

Every page includes smooth scroll-based animations powered by GSAP ScrollTrigger:

### Fade In
Elements fade in as you scroll into view - see the homepage hero section, product cards, and feature boxes.

### Scale
Items grow/scale up as they become visible - check out the featured products on the homepage.

### Counters
Numbers animate when scrolled into view - notice the statistics section ("50000+ Happy Customers", etc.)

### Staggered
Groups of items animate with a slight delay between each - see the featured products grid and feature boxes.

---

## 📊 Sample Product Data

### 1. Midnight Elegance
- Category: Men
- Price: $69.99 (was $89.99 - 22% off)
- Volume: 100ml
- Scent: Woody
- Longevity: 8-10 hours
- Projection: Strong

### 2. Rose Garden
- Category: Women
- Price: $79.99
- Volume: 50ml
- Scent: Floral
- Longevity: 6-8 hours
- Projection: Moderate

### 3. Ocean Breeze
- Category: Men
- Price: $54.99 (was $74.99 - 27% off)
- Volume: 100ml
- Scent: Fresh
- Longevity: 5-7 hours
- Projection: Moderate
- ⭐ Featured on homepage

### 4. Amber Sunset
- Category: Women
- Price: $84.99
- Volume: 75ml
- Scent: Oriental
- Longevity: 10+ hours
- Projection: Strong
- ⭐ Featured on homepage

### 5. Citrus Paradise
- Category: Men
- Price: $69.99
- Volume: 100ml
- Scent: Citrus
- Longevity: 5-6 hours
- Projection: Moderate
- ⭐ Featured on homepage

### 6. Jasmine Dreams
- Category: Women
- Price: $74.99 (was $94.99 - 21% off)
- Volume: 50ml
- Scent: Floral
- Longevity: 8-9 hours
- Projection: Moderate
- ⭐ Featured on homepage

---

## 🐛 Troubleshooting

**Q: Server won't start**
- Make sure port 8000 is available
- Try: `php -S localhost:8001 -t public` (different port)

**Q: Database errors**
- Run: `php setup.php` again
- Make sure `database/` folder is writable

**Q: No products showing**
- Run: `php setup.php` to seed data
- Clear browser cache (Ctrl+Shift+Delete)

**Q: Animations not working**
- Check browser console for errors (F12)
- Make sure JavaScript is enabled
- Try a different browser

**Q: Can't add products**
- Make sure you have write permissions
- Check browser console for form errors

---

## 📚 File Structure Quick Reference

```
Key Files to Edit:
├── resources/views/home.blade.php          ← Homepage content
├── resources/views/layouts/app.blade.php   ← Colors & animations
├── setup.php                               ← Add sample data
└── app/Models/Product.php                  ← Product schema

Data:
├── database/patel_perfumes.db              ← SQLite database
├── database/migrations/                    ← Table definitions
└── setup.php                               ← Seed data
```

---

## 🚀 Next Steps

1. ✅ Run setup.php
2. ✅ Start the server
3. ✅ Visit homepage
4. ✅ Browse products
5. ✅ Try adding to cart
6. ✅ Go through checkout
7. ✅ Check admin panel
8. ✅ Create a new product
9. ✅ Scroll and enjoy animations!

---

## 💡 Pro Tips

- **Scroll animations are automatic** - Just use `data-scroll-fade`, `data-scroll-scale`, etc. in Blade templates
- **Database is SQLite** - No MySQL needed, everything is contained
- **Session-based cart** - Items persist during the session
- **Admin panel is open** - No login required (change in production!)
- **Tailwind CSS** - All styling uses utility classes for easy customization

---

## 🎓 Learning Resources

- **GSAP ScrollTrigger**: https://greensock.com/scrolltrigger/
- **Blade Templating**: https://laravel.com/docs/blade
- **Tailwind CSS**: https://tailwindcss.com/docs

---

**Ready? Type `php -S localhost:8000 -t public` and start! 🚀**
