# Patel Perfumes - Architecture & Technical Documentation

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────┐
│           Patel Perfumes E-Commerce Platform          │
├─────────────────────────────────────────────────────┤
│                                                     │
│  ┌─────────────────────────────────────────────┐   │
│  │       Frontend Layer (Blade Templates)       │   │
│  │  - home.blade.php                            │   │
│  │  - products/                                 │   │
│  │  - cart/, checkout/, order/                  │   │
│  │  - admin/                                    │   │
│  └─────────────────────────────────────────────┘   │
│                        ↓                            │
│  ┌─────────────────────────────────────────────┐   │
│  │      Routing Layer (routes/web.php)          │   │
│  │  - URL patterns                              │   │
│  │  - Route definitions                         │   │
│  └─────────────────────────────────────────────┘   │
│                        ↓                            │
│  ┌─────────────────────────────────────────────┐   │
│  │   Controller Layer (app/Http/Controllers)    │   │
│  │  - HomeController                            │   │
│  │  - ProductController                         │   │
│  │  - CartController                            │   │
│  │  - CheckoutController                        │   │
│  │  - Admin/*Controller                         │   │
│  └─────────────────────────────────────────────┘   │
│                        ↓                            │
│  ┌─────────────────────────────────────────────┐   │
│  │      Model Layer (app/Models)                │   │
│  │  - Product (products table)                  │   │
│  │  - Category (categories table)               │   │
│  │  - Order (orders table)                      │   │
│  │  - OrderItem (order_items table)             │   │
│  │  - User (users table)                        │   │
│  └─────────────────────────────────────────────┘   │
│                        ↓                            │
│  ┌─────────────────────────────────────────────┐   │
│  │     Database Layer (SQLite)                  │   │
│  │  - patel_perfumes.db                         │   │
│  │  - 5 core tables with relationships          │   │
│  └─────────────────────────────────────────────┘   │
│                                                     │
└─────────────────────────────────────────────────────┘

       │
       ├─→ GSAP ScrollTrigger (Animations)
       ├─→ Tailwind CSS (Styling)
       ├─→ Session Management (Cart)
       └─→ SQLite3 (Database)
```

---

## 📁 Directory Structure

### `/app` - Application Code
```
app/
├── Application.php               ← Bootstrap application
├── Database.php                  ← SQLite connection & migration runner
├── Models/
│   ├── User.php                 ← User model (with password hashing)
│   ├── Product.php              ← Product with relationships
│   ├── Category.php             ← Product categories
│   ├── Order.php                ← Order headers
│   └── OrderItem.php            ← Order line items
└── Http/
    └── Controllers/
        ├── Controller.php       ← Base controller
        ├── HomeController.php   ← Homepage logic
        ├── ProductController.php ← Product listing/detail
        ├── CartController.php   ← Cart management
        ├── CheckoutController.php ← Order creation
        ├── OrderController.php  ← Order confirmation
        └── Admin/
            ├── ProductController.php ← Admin CRUD for products
            └── CategoryController.php ← Admin CRUD for categories
```

### `/database` - Database Files
```
database/
├── patel_perfumes.db           ← SQLite database file
├── migrations/
│   ├── 2024_01_01_000001_create_users_table.php
│   ├── 2024_01_01_000002_create_categories_table.php
│   ├── 2024_01_01_000003_create_products_table.php
│   ├── 2024_01_01_000004_create_orders_table.php
│   └── 2024_01_01_000005_create_order_items_table.php
└── seeders/
    └── DatabaseSeeder.php      ← Sample data (run via setup.php)
```

### `/resources/views` - Templates
```
resources/views/
├── layouts/
│   ├── app.blade.php           ← Main layout with animations & colors
│   ├── header.blade.php        ← Navigation & cart
│   └── footer.blade.php        ← Footer with links
├── home.blade.php              ← Homepage with scroll animations
├── products/
│   ├── index.blade.php         ← Product listing with filters
│   ├── show.blade.php          ← Product detail page
│   └── by-category.blade.php   ← Category page
├── cart/
│   └── index.blade.php         ← Shopping cart
├── checkout/
│   └── index.blade.php         ← Checkout form & summary
├── order/
│   └── confirmation.blade.php  ← Order confirmation
└── admin/
    ├── layouts/
    │   └── app.blade.php       ← Admin layout
    ├── products/
    │   ├── index.blade.php     ← Product list
    │   └── create.blade.php    ← Product form
    └── categories/
        └── index.blade.php     ← Category list
```

### `/routes` - URL Routing
```
routes/
└── web.php                     ← All URL routes defined here
```

### `/public` - Web Root
```
public/
├── index.php                   ← Entry point
└── css/
    └── app.css                 ← Compiled Tailwind CSS (optional)
```

### `/config` - Configuration
```
config/
└── app.php                     ← App configuration
```

---

## 🗄️ Database Schema

### Tables & Relationships

#### `users` Table
```sql
users
├── id (PRIMARY KEY)
├── name (VARCHAR)
├── email (UNIQUE)
├── password (BCRYPT hashed)
├── phone (VARCHAR)
├── address, city, state, postal_code, country (Location)
├── is_admin (BOOLEAN)
├── created_at, updated_at (TIMESTAMPS)
└── Relationships:
    └── hasMany(Order)
```

#### `categories` Table
```sql
categories
├── id (PRIMARY KEY)
├── name (VARCHAR)
├── slug (UNIQUE) ← For URL-friendly names
├── description (TEXT)
├── image_url (VARCHAR)
├── created_at, updated_at (TIMESTAMPS)
└── Relationships:
    └── hasMany(Product)
```

#### `products` Table
```sql
products
├── id (PRIMARY KEY)
├── name (VARCHAR)
├── slug (UNIQUE)
├── description (TEXT) ← Short description
├── long_description (TEXT) ← Full description
├── price (DECIMAL)
├── discount_price (DECIMAL, NULLABLE)
├── category_id (FOREIGN KEY → categories)
├── image_url (VARCHAR)
├── gallery_images (JSON) ← Array of image URLs
├── Fragrance Details:
│   ├── volume (VARCHAR) ← "100ml"
│   ├── scent_profile (VARCHAR) ← "Floral"
│   ├── longevity (VARCHAR) ← "8-10 hours"
│   ├── projection (VARCHAR) ← "Strong"
│   └── notes (JSON) ← ["Rose", "Musk", "Sandalwood"]
├── in_stock (BOOLEAN)
├── is_featured (BOOLEAN) ← Shows on homepage
├── created_at, updated_at (TIMESTAMPS)
└── Relationships:
    ├── belongsTo(Category)
    └── hasMany(OrderItem)
```

#### `orders` Table
```sql
orders
├── id (PRIMARY KEY)
├── user_id (FOREIGN KEY → users)
├── order_number (UNIQUE) ← "ORD-1234567890"
├── subtotal (DECIMAL)
├── tax (DECIMAL) ← 8% of subtotal
├── total (DECIMAL) ← subtotal + tax + shipping
├── status (VARCHAR) ← "pending", "processing", "shipped", "delivered"
├── payment_method (VARCHAR) ← "credit_card", "debit_card", "paypal"
├── shipping_address (JSON) ← Full address object
├── billing_address (JSON) ← Full address object
├── notes (TEXT)
├── created_at, updated_at (TIMESTAMPS)
└── Relationships:
    ├── belongsTo(User)
    └── hasMany(OrderItem)
```

#### `order_items` Table
```sql
order_items
├── id (PRIMARY KEY)
├── order_id (FOREIGN KEY → orders)
├── product_id (FOREIGN KEY → products)
├── quantity (INTEGER)
├── price (DECIMAL) ← Price at time of purchase
├── subtotal (DECIMAL) ← quantity × price
├── created_at, updated_at (TIMESTAMPS)
└── Relationships:
    ├── belongsTo(Order)
    └── belongsTo(Product)
```

---

## 🔄 Data Flow

### Product Browsing Flow
```
User Visits /
    ↓
HomeController::index()
    ↓
Query: Product::where('is_featured', true)->take(6)
    ↓
Return featured products + categories
    ↓
Render: home.blade.php (with animations)
```

### Shopping Flow
```
User Clicks "Add to Cart"
    ↓
CartController::add($productId)
    ↓
Session::put('cart', [...])
    ↓
Redirect to Cart
    ↓
Display cart items with totals
```

### Checkout Flow
```
User Submits Checkout Form
    ↓
CheckoutController::store()
    ↓
Validate Input
    ↓
Create/Find User
    ↓
Create Order Record
    ↓
Create OrderItems (one per cart item)
    ↓
Clear Session Cart
    ↓
Redirect to Confirmation Page
```

### Admin Product Management
```
Admin Views /admin/products
    ↓
AdminProductController::index()
    ↓
Paginate: Product::paginate(20)
    ↓
Display Products in Table
    ↓
Admin Clicks "Create"/"Edit"/"Delete"
    ↓
Handle CRUD Operations
    ↓
Update Database
    ↓
Redirect with Success Message
```

---

## 🎨 Frontend Architecture

### Blade Template Structure
```
layouts/app.blade.php
├── <head> with GSAP & Tailwind
├── @include('layouts.header')
├── <main>
│   @yield('content')
│   └── Individual page content
├── @include('layouts.footer')
└── JavaScript animations initialization
```

### Animation System (GSAP ScrollTrigger)

#### Initialization in `app.blade.php`
```javascript
gsap.registerPlugin(ScrollTrigger);

// Fade animations
gsap.utils.toArray('[data-scroll-fade]').forEach(element => {
    gsap.to(element, {
        opacity: 1,
        y: 0,
        scrollTrigger: { trigger: element, start: 'top 80%' }
    });
});

// Scale animations
// Counter animations
// Staggered animations
```

#### Usage in Templates
```blade
<!-- Fade in animation -->
<div data-scroll-fade style="opacity: 0; transform: translateY(30px);">
    Content fades in on scroll
</div>

<!-- Counter animation -->
<span data-counter="1000">0</span>

<!-- Staggered group -->
<div data-scroll-stagger>
    <div data-stagger-item>Item 1</div>
    <div data-stagger-item>Item 2</div>
</div>
```

### Styling System

#### CSS Variables (in `app.blade.php`)
```css
:root {
    --primary: #8B6F47;      /* Main brand color */
    --secondary: #F5E6D3;    /* Light accent */
    --accent: #D4AF37;       /* Gold highlights */
    --dark: #2C2C2C;         /* Text/dark areas */
    --light: #FAFAF8;        /* Page background */
}
```

#### Tailwind Integration
- **Colors**: `bg-primary`, `text-primary`, `border-accent`
- **Spacing**: Standard Tailwind scale
- **Responsive**: `md:` and `lg:` prefixes for tablets/desktops
- **Utilities**: `flex`, `grid`, `rounded`, `shadow`, etc.

---

## 📡 API/Route Handlers

### Frontend Routes
| Route | Method | Controller | Action |
|-------|--------|-----------|--------|
| `/` | GET | HomeController | index |
| `/products` | GET | ProductController | index |
| `/products/{slug}` | GET | ProductController | show |
| `/category/{slug}` | GET | ProductController | byCategory |
| `/cart` | GET | CartController | index |
| `/cart/{product}` | POST | CartController | add |
| `/cart/{product}` | PUT | CartController | update |
| `/cart/{product}` | DELETE | CartController | remove |
| `/checkout` | GET | CheckoutController | index |
| `/checkout` | POST | CheckoutController | store |
| `/order/{id}/confirmation` | GET | OrderController | confirmation |

### Admin Routes
| Route | Method | Controller | Action |
|-------|--------|-----------|--------|
| `/admin/products` | GET | Admin\ProductController | index |
| `/admin/products/create` | GET | Admin\ProductController | create |
| `/admin/products` | POST | Admin\ProductController | store |
| `/admin/products/{id}/edit` | GET | Admin\ProductController | edit |
| `/admin/products/{id}` | PUT | Admin\ProductController | update |
| `/admin/products/{id}` | DELETE | Admin\ProductController | destroy |
| `/admin/categories` | GET | Admin\CategoryController | index |
| `/admin/categories/create` | GET | Admin\CategoryController | create |
| `/admin/categories` | POST | Admin\CategoryController | store |
| `/admin/categories/{id}/edit` | GET | Admin\CategoryController | edit |
| `/admin/categories/{id}` | PUT | Admin\CategoryController | update |
| `/admin/categories/{id}` | DELETE | Admin\CategoryController | destroy |

---

## 🔐 Security Considerations

### Current Implementation
- ✅ Password hashing with bcrypt
- ✅ SQL injection prevention (prepared statements)
- ✅ Session-based state management
- ✅ Form validation

### Production Recommendations
- 🔒 Add CSRF token validation
- 🔒 Implement proper authentication middleware
- 🔒 Add rate limiting for sensitive routes
- 🔒 Use HTTPS only
- 🔒 Validate file uploads
- 🔒 Add admin authentication
- 🔒 Implement proper payment gateway integration

---

## 🚀 Performance Optimization

### Current Optimizations
- ✅ Lazy loading animations (only when in view)
- ✅ Pagination for product lists
- ✅ SQLite for lightweight database
- ✅ Session-based cart (no database writes)
- ✅ CSS utility-based styling (small footprint)

### Future Improvements
- 📈 Add database indexing for queries
- 📈 Implement caching for product listings
- 📈 Image optimization and lazy loading
- 📈 Minify CSS/JS in production
- 📈 Implement database query optimization
- 📈 Add Redis for session storage

---

## 🔧 Configuration Files

### `.env` - Environment Variables
```env
APP_NAME="Patel Perfumes"
APP_ENV=local
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/patel_perfumes.db
```

### `config/app.php` - Application Configuration
- App name and timezone
- Debug mode
- URL base path

### `package.json` - Frontend Dependencies
- GSAP (animations)
- Tailwind CSS (styling)
- Autoprefixer (CSS compatibility)

---

## 📊 Data Processing Examples

### Calculate Discount Percentage
```php
// In Product model
public function getDiscountPercentageAttribute() {
    if ($this->discount_price && $this->price) {
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }
    return 0;
}
```

### Session Cart Management
```php
// In CartController
$cart = session()->get('cart', []); // Get or default to []
$cart[$productId] = $quantity;      // Add/update item
session()->put('cart', $cart);      // Save back to session
```

### Calculate Order Totals
```php
$subtotal = sum of all item subtotals
$tax = $subtotal * 0.08  // 8% tax rate
$shipping = $subtotal >= 50 ? 0 : 10  // Free shipping over $50
$total = $subtotal + $tax + $shipping
```

---

## 🧪 Testing Checklist

- [ ] Database setup completes without errors
- [ ] All sample products display on homepage
- [ ] Add to cart functionality works
- [ ] Cart totals calculate correctly
- [ ] Checkout form validates properly
- [ ] Order creates successfully
- [ ] Scroll animations trigger on all pages
- [ ] Admin product creation works
- [ ] Admin product editing works
- [ ] Admin product deletion works
- [ ] Category filtering works
- [ ] Product search/filter works
- [ ] Responsive design looks good on mobile
- [ ] Page navigation is smooth
- [ ] No console errors in browser

---

## 📚 Technologies Used

| Component | Technology | Version |
|-----------|-----------|---------|
| **Framework** | Laravel-inspired PHP | 8.1+ |
| **Templating** | Blade | Native |
| **Database** | SQLite3 | 3.x |
| **CSS Framework** | Tailwind CSS | 4.2+ |
| **Animation** | GSAP + ScrollTrigger | 3.12+ |
| **Build Tool** | npm | Latest |
| **Server** | PHP Built-in | 8.1+ |

---

## 🔗 Key Files Reference

### To Change Colors
→ `/resources/views/layouts/app.blade.php` (CSS variables section)

### To Change Homepage Content
→ `/resources/views/home.blade.php`

### To Add New Product Fields
→ `/app/Models/Product.php` (add to $fillable)
→ Update migration or direct table alteration

### To Modify Animations
→ `/resources/views/layouts/app.blade.php` (JavaScript section)

### To Change Routes
→ `/routes/web.php`

### To Add Admin Features
→ `/app/Http/Controllers/Admin/*Controller.php`
→ Add new admin views in `/resources/views/admin/`

---

This architecture provides a solid, scalable foundation for an e-commerce platform with room for growth and enhancement!
