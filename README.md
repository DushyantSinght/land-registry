# 🏛 Land Real Estate Registration System

A comprehensive **Government Land Registry System** built with **Laravel 11**, featuring property registration, ownership management, deed transfers, PDF generation, and role-based access control.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Default Users](#default-users)
- [Module Overview](#module-overview)
- [Database Schema](#database-schema)
- [Role Permissions](#role-permissions)
- [Screenshots](#screenshots)
- [Project Structure](#project-structure)

---

## ✨ Features

### Core Modules
| Module | Description |
|--------|-------------|
| 🔐 **Authentication** | Secure login with role-based access |
| 📊 **Dashboard** | Stats, charts, pending approvals, recent activity |
| 👤 **Owner Management** | Register land holders (individual/company/govt) |
| 🗺️ **Property Management** | Land parcels with location, area, valuation |
| 📄 **Registration** | Deed registration (sale, gift, will, partition, etc.) |
| 🔄 **Transfers** | Ownership transfer workflow with approval |
| 📈 **Reports** | Analytics and PDF exports |
| 👥 **User Management** | System users and role assignments |

### Key Capabilities
- ✅ Full **CRUD** for owners, properties, registrations, transfers
- ✅ **Approval workflow** — registrar approves/rejects applications
- ✅ **PDF generation** — property certificates & payment receipts
- ✅ **Auto stamp duty calculator** (4% of transaction value)
- ✅ **Property ownership history** tracking
- ✅ **Search & filter** across all modules
- ✅ **Soft deletes** for audit trail
- ✅ **File uploads** — deed documents, ID proofs, site plans
- ✅ **Responsive UI** with Bootstrap 5 + Bootstrap Icons
- ✅ **Chart.js** dashboard analytics

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Database | MySQL 8.0+ |
| Frontend | Bootstrap 5.3, Chart.js 4, Bootstrap Icons |
| PDF | barryvdh/laravel-dompdf |
| Auth | Laravel built-in authentication |

---

## 🖥 System Requirements

- PHP >= 8.2
- Composer
- MySQL 8.0+ (or MariaDB 10.3+)
- Node.js >= 18 (optional, for asset compilation)
- PHP extensions: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`

---

## 🚀 Installation

### 1. Clone / Extract the Project

```bash
git clone https://github.com/your-org/land-registry.git
cd land-registry
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=land_registry
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Create Database

```sql
CREATE DATABASE land_registry CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
```

### 6. Storage Link (for file uploads)

```bash
php artisan storage:link
```

### 7. Start Development Server

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## 👥 Default Users

After seeding, these accounts are available:

| Role | Email | Password |
|------|-------|----------|
| **Administrator** | admin@landregistry.gov | password |
| **Registrar** | registrar@landregistry.gov | password |
| **Viewer** | viewer@landregistry.gov | password |

---

## 📦 Module Overview

### 🏠 Dashboard
- Total properties, owners, pending registrations
- Revenue collected (stamp duty + fees)
- Land type distribution (doughnut chart)
- Monthly registration bar chart
- Quick-access pending approval table

### 👤 Owner Management
- Register individuals, companies, and government bodies
- Unique ID number validation (Aadhaar, Passport, PAN, Company Reg.)
- Upload photo and ID document
- View all owned properties
- Active/Inactive toggle

### 🗺 Property Management
- Auto-generated survey numbers (`SRV-2024-000001`)
- Seven land types: Agricultural, Residential, Commercial, Industrial, Forest, Government, Other
- Area in Sq.ft, Sq.m, and Acres
- Market value and Government (circle rate) value
- Dispute tracking
- Upload site plan and survey documents
- Ownership history timeline
- Download property title certificate (PDF)

### 📄 Registration
- Auto-generated reg. numbers (`REG-2024-00001`)
- Seven deed types: First Registration, Sale, Gift, Will, Partition, Lease, Mortgage
- Stamp duty auto-calculator (4% of transaction value)
- Witness details
- Document uploads (deed, supporting docs)
- Pending → Approved / Rejected workflow
- Download payment receipt (PDF)

### 🔄 Transfers
- Transfer registered properties between owners
- Modes: Sale, Gift, Inheritance, Court Order, Exchange
- Auto-updates property owner on approval
- Logs history event on approval

### 📈 Reports
- Revenue summary (stamp duty + registration fees)
- Properties by land type table
- Properties by district chart
- Monthly revenue trend chart
- Exportable PDF reports (registrations, properties)

### 👥 User Management (Admin only)
- Create registrar and viewer accounts
- Assign roles: Admin, Registrar, Viewer
- Activate / deactivate accounts

---

## 🗄 Database Schema

```
users                   — System users (admin, registrar, viewer)
owners                  — Land holders / applicants
properties              — Land parcels
registrations           — Deed registration records
transfers               — Ownership transfer records
property_histories      — Ownership event log
```

### Key Relationships
```
Owner      ──< Property        (one owner → many properties)
Property   ──< Registration    (one property → many registrations)
Property   ──< Transfer        (one property → many transfers)
Owner      ──< Registration    (one owner → many registrations)
Property   ──< PropertyHistory (one property → many history events)
```

---

## 🔐 Role Permissions

| Action | Admin | Registrar | Viewer |
|--------|-------|-----------|--------|
| View all records | ✅ | ✅ | ✅ |
| Create owners/properties | ✅ | ✅ | ❌ |
| Submit registrations | ✅ | ✅ | ❌ |
| Submit transfers | ✅ | ✅ | ❌ |
| **Approve/Reject** registrations | ✅ | ✅ | ❌ |
| **Approve/Reject** transfers | ✅ | ✅ | ❌ |
| View reports | ✅ | ❌ | ❌ |
| Manage users | ✅ | ❌ | ❌ |
| Delete records | ✅ | ❌ | ❌ |

---

## 📁 Project Structure

```
land-registry/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── OwnerController.php
│   │   │   ├── PropertyController.php
│   │   │   ├── RegistrationController.php
│   │   │   ├── TransferController.php
│   │   │   ├── ReportController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Owner.php
│       ├── Property.php
│       ├── Registration.php
│       ├── Transfer.php
│       └── PropertyHistory.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_owners_table.php
│   │   ├── ..._create_properties_table.php
│   │   └── ..._create_registrations_table.php  (+ transfers, histories)
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── auth/login.blade.php
│   ├── dashboard/index.blade.php
│   ├── owners/         (index, create, edit, show, properties)
│   ├── properties/     (index, create, edit, show, history, certificate-pdf)
│   ├── registrations/  (index, create, edit, show, receipt-pdf)
│   ├── transfers/      (index, create, edit, show)
│   ├── reports/        (index, registrations, properties, owners, pdf/)
│   └── users/          (index, create, edit)
├── routes/web.php
├── bootstrap/app.php
└── .env.example
```

---

## 🔧 Customization

### Stamp Duty Rate
Edit in `resources/views/registrations/create.blade.php`:
```javascript
document.getElementById('stamp_duty').value = (val * 0.04).toFixed(2);    // 4%
document.getElementById('registration_fee').value = (val * 0.01).toFixed(2); // 1%
```

### Adding New Land Types
Update the `land_type` enum in:
1. Migration file
2. Property model's `$fillable`
3. Blade views (dropdowns)

### PDF Customization
Edit the Blade templates in:
- `resources/views/properties/certificate-pdf.blade.php`
- `resources/views/registrations/receipt-pdf.blade.php`
- `resources/views/reports/pdf/*.blade.php`

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Migrations fail | Check DB credentials in `.env` |
| File uploads fail | Run `php artisan storage:link` |
| PDF not generating | Install GD: `sudo apt install php-gd` |
| 403 on routes | Check user role assignments |

---

## 📜 License

MIT License — Free for educational and government use.

---

*Built with ❤️ using Laravel 11 + Bootstrap 5*
