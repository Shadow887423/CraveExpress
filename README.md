# 🍔 CraveExpress — Fast, Flavorful Food Delivery Web Platform

[![GitHub Pages Ready](https://img.shields.io/badge/GitHub%20Pages-Ready-2ea44f?style=for-the-badge&logo=github)](https://pages.github.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777bb4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/)
[![CSS3](https://img.shields.io/badge/CSS3-Modern%20UI-1572B6?style=for-the-badge&logo=css3)](https://www.w3.org/Style/CSS/)
[![Database](https://img.shields.io/badge/SQL%20Server-CraveExpressDB-CC292B?style=for-the-badge&logo=microsoft-sql-server)](https://www.microsoft.com/sql-server)

> **Crave the best. Delivered to your door.**  
> An end-to-end, modern food delivery web application built with a responsive UI, persistent multi-page basket system, real-time live courier tracking simulation, discount voucher engine, multi-tab account settings, and 24/7 customer care.

---

## 🚀 Live Demo & Deployment Modes

CraveExpress is engineered with **dual deployment compatibility**:
1. **GitHub Pages (Zero-Server Static Hosting)**: Can be deployed to GitHub Pages with **zero backend server required**. All features (cart, checkout, orders tracking, simulated authentication, and profile editing) run seamlessly in the browser using HTML5 `localStorage` and client-side JavaScript.
2. **Full-Stack PHP & SQL Server (Local / Server Hosting)**: Can be hosted with XAMPP, Apache, Docker, or IIS with live database persistence via Microsoft SQL Server (`sqlsrv`).

---

## 📱 Page-by-Page Overview

| Page | URL (.html / .php) | Key Features |
| :--- | :--- | :--- |
| **Home / Landing** | `index.html` / `index.php` | Hero search, popular category shortcuts, trending restaurants spotlight, Why CraveExpress feature cards, voucher promo banner, and footer. |
| **Restaurants** | `restaurants.html` / `restaurants.php` | Live real-time search, multi-cuisine filtering (Burgers, Pizza, Italian, Asian, Sushi, etc.), price range (`$`, `$$`, `$$$`, `$$$$`), and Grid/List view switcher. |
| **Menu Page** | `urbangrillmenu.html` / `urbangrillmenu.php` | Dynamic restaurant theming (`?restaurant=`), sticky category tabs (Mains, Sides, Drinks, Desserts, Vegan), item cards with dietary tags, and live order sidebar. |
| **Sides Specialty** | `urbangrillmenuslides.html` / `urbangrillmenuslides.php` | Dedicated handcrafted sides & appetizers menu with Truffle Fries, Onion Rings, and Sweet Potato Wedges. |
| **Checkout** | `checkout.html` / `checkout.php` | Multi-step delivery address, delivery speed selection (Standard vs Priority), payment options (Credit Card, COD, GCash, PayPal), promo voucher validator, and live tax/total calculation. |
| **Orders & Tracking** | `orders.html` / `orders.php` | 4-step live order status stepper, simulated live GPS delivery route with animated courier scooter, driver details, countdown timer, and order history with one-click reordering and printable receipts. |
| **Account Settings** | `profile_settings.html` / `profile_settings.php` | Multi-tab settings: Profile (photo upload & name/phone), Security (password change & active sessions), Saved Addresses (Home, Office), and Payment Methods. |
| **Help & Support** | `help.html` / `help.php` | 24/7 Knowledge Base with live keyword search, accordion FAQs, support ticket submission, and **interactive CraveBot live chat simulator**. |
| **Partner With Us** | `partner.html` / `partner.php` | Merchant growth metrics, Restaurant Partner application form, and Courier Driver onboarding form. |
| **Authentication** | `login.html` & `signup.html` | Password visibility toggles (👁/🙈), social login shortcuts, forgot password flow, and demo mode credentials. |

---

## 🎁 Active Voucher Codes

Test the checkout voucher system using these promo codes:
- **`CRAVEFIRST`** — $10.00 Off your order
- **`SAVE5`** — $5.00 Off your order
- **`FREEDEL`** — Free Delivery unlocked

---

## 🌐 How to Deploy to GitHub Pages in 2 Minutes

### Step 1: Initialize Git and Commit
Open PowerShell or your terminal in this project directory:
```bash
git init
git add .
git commit -m "Initial commit - Complete CraveExpress food delivery platform"
```

### Step 2: Push to GitHub
1. Create a new repository on [GitHub](https://github.com/new) named `craveexpress` (set to **Public**).
2. Link your local project and push:
```bash
git branch -M main
git remote add origin https://github.com/<YOUR-USERNAME>/craveexpress.git
git push -u origin main
```

### Step 3: Enable GitHub Pages
1. On GitHub, navigate to your repository's **Settings**.
2. In the left sidebar, click **Pages**.
3. Under **Build and deployment > Source**, select **Deploy from a branch**.
4. Set branch to **`main`** and folder to **`/(root)`**, then click **Save**.
5. Within 60 seconds, your site is live at:  
   👉 `https://<YOUR-USERNAME>.github.io/craveexpress/`

*(Alternatively, the included `.github/workflows/deploy.yml` will automatically deploy your site using GitHub Actions!)*

---

## 💻 How to Run Locally with PHP / XAMPP

### Option A: Built-in PHP Server (Fastest)
Run the following in PowerShell:
```powershell
php -S localhost:8000
```
Open [http://localhost:8000/index.php](http://localhost:8000/index.php) in your browser.

### Option B: Apache / XAMPP
1. Move or symlink the folder into `C:\xampp\htdocs\CraveExpress`.
2. Start **Apache** in XAMPP Control Panel.
3. Open [http://localhost/CraveExpress/index.php](http://localhost/CraveExpress/index.php).

### Option C: Database Setup (Optional)
If using SQL Server:
1. Open SQL Server Management Studio (SSMS).
2. Execute the script inside `CraveExpressDB.sql` to create `CraveExpressDB` and the `Users` table.
3. Update your server instance name in `Backend/db_config.php` (defaults to `Paulo\SQLEXPRESS`).

> **Note:** If SQL Server is offline, CraveExpress automatically activates **Demo Mode** so you can preview, log in, sign up, and test all features without interruption!

---

## 📂 Project Structure

```
CraveExpress/
├── .github/
│   └── workflows/
│       └── deploy.yml           # Automated GitHub Pages deployment workflow
├── Backend/
│   ├── db_config.php            # Database connection configuration
│   ├── db_connect.php           # Resilient SQL connection with fallback handling
│   ├── login_process.php        # Authentication endpoint
│   ├── signup.php               # User registration endpoint
│   ├── update_profile.php       # Profile, security, and address updates
│   └── logout.php               # Session termination
├── Design/
│   ├── design1.css              # Typography, layout, hero, why section, promo banner
│   ├── design2.css              # Restaurant grid, list view styles, sidebar filters
│   ├── design3.css              # Menu item layout, category tabs, sticky sidebar
│   ├── common.css               # Slide-out cart drawer, toast notifications, footer
│   ├── checkout.css             # Step-by-step checkout UI, payment tabs, calculation rows
│   ├── orders.css               # Status stepper, simulated SVG delivery map, driver card
│   ├── profile_settings.css     # Settings layout, photo upload, form rows
│   ├── login.css                # Split-screen login interface
│   └── signup.css               # Split-screen signup interface
├── JavaScript/
│   ├── cart.js                  # Universal persistent cart engine, drawer UI, route adapter
│   ├── control1.js              # Landing page category routing and search
│   ├── control2.js              # Menu addition and category tab filtering
│   ├── restaurants.js           # Live restaurant filtering, search, and view toggle
│   ├── profile_settings.js      # Multi-tab settings switcher and avatar upload
│   ├── login.js                 # Authentication logic with GitHub Pages fallback
│   └── signup.js                # Registration logic with GitHub Pages fallback
├── CraveExpressDB.sql           # Database schema for Microsoft SQL Server
├── UserDetails.sql              # Alternate table definition
├── index.html / index.php       # Home page (Static & PHP)
├── restaurants.html / .php      # Restaurants catalog (Static & PHP)
├── urbangrillmenu.html / .php   # Restaurant menu (Static & PHP)
├── urbangrillmenuslides.html / .php # Specialty sides menu (Static & PHP)
├── checkout.html / .php         # Checkout and payment (Static & PHP)
├── orders.html / .php           # Live order tracking & history (Static & PHP)
├── profile_settings.html / .php # User account settings (Static & PHP)
├── help.html / .php             # Help center and CraveBot AI (Static & PHP)
├── partner.html / .php          # Restaurant and driver onboarding (Static & PHP)
├── login.html                   # Login page
├── signup.html                  # Signup page
├── .gitignore                   # Ignored files for clean git tracking
├── .gitattributes               # Cross-platform line ending normalization
└── README.md                    # Project documentation
```

---

## 👨‍💻 Credits & License

- Designed & Developed for **CraveExpress** Food Delivery.
- Typography: [Inter by Rasmus Andersson](https://fonts.google.com/specimen/Inter).
- Imagery: High-resolution culinary photography from [Unsplash](https://unsplash.com/).
- Open source under the [MIT License](https://opensource.org/licenses/MIT).
