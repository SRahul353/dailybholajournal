# Daily Bhola Journal (দৈনিক ভোলা জার্নাল)

A modern, fast, and feature-rich online news portal and digital e-paper platform built with Laravel.

---

## Features

- **Dynamic Homepage**: Highlighting Lead News, Sub-lead News, Latest News, and Category blocks.
- **Admin Control Panel**: Custom admin dashboard to manage posts, categories, tags, users, and e-paper layouts.
- **Interactive E-Paper Builder**: Drag-and-drop / zone mapping digital e-paper edition viewer & manager.
- **Social Card Generator**: Auto-generates shareable social cards for breaking news articles.
- **Live Theme Customizer**: Real-time theme styling, branding (logo, colors, typography, editorial details).
- **SEO & Social Media Optimized**: OpenGraph, Twitter Cards, structured schema, clean URLs and Bengali slug routing.

---

## Local Development & Setup

This project is hosted locally via Laravel Herd / XAMPP.

- **Local Domain**: `http://dailybholajournal.test`
- **Database**: `dailybholajournal` (MySQL utf8mb4)
- **Admin Panel**: `http://dailybholajournal.test/admin/login`

### Default Admin Credentials

- **Email**: `admin@dailybholajournal.com`
- **Password**: `admin123`

---

## Useful Commands

```bash
# Clear all application cache
php artisan optimize:clear

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```
