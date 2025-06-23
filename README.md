# YajraProductify
A Laravel 12 Product Management App using Yajra DataTables, Breeze Auth, Tailwind CSS, SweetAlert2, and AJAX — with image upload and column filtering.

# YajraProductify

🛍️ A sleek Laravel 12 product management system powered by **Yajra DataTables** and **Tailwind CSS** — complete with:

- Breeze-based authentication
- AJAX DataTables integration
- Column filters
- Image upload with validation
- SweetAlert2 confirmation for deletes
- A modern, responsive UI

---

## 🚀 Features

- 🧾 Add, Edit, Delete products
- 📸 Upload product images (with validation)
- 🔍 Column-wise search filters (ID, name, description, price)
- 📊 Server-side pagination & search via Yajra
- ✅ SweetAlert2 confirmation modals
- 💡 Responsive UI built with Tailwind CSS
- 🔐 Auth system via Laravel Breeze

---

## ⚙️ Installation

```bash
git clone https://github.com/your-username/yajraproductify.git
cd yajraproductify

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

# Setup DB credentials in .env
php artisan migrate
