# WP AutoPublish Plugin

WordPress plugin that allows uploading HTML files and automatically creating draft posts from them.

## 🚀 Features (POC v1)

- Upload HTML file from WordPress admin
- Automatically create a draft post
- Insert raw HTML as post content

## 🧱 Architecture

The plugin follows a clean architecture approach:

- `admin/` → WordPress admin UI and controllers
- `domain/` → Business logic (HTML processing, import logic)
- `views/` → Shared views
- `bootstrap/` → Plugin initialization

## 📦 Installation

1. Clone the repository into `/wp-content/plugins/`
2. Activate the plugin from WordPress admin
3. Go to **AutoPublish** menu

## 🧪 Usage

1. Upload an `.html` file
2. Click "Upload and create draft"
3. Edit the generated post

## 🔜 Roadmap

- [ ] Support for images upload and processing
- [ ] Replace image URLs with WordPress media library URLs
- [ ] Extract metadata (title, excerpt)
- [ ] Mailchimp integration
- [ ] HTML sanitization and validation

## ⚠️ Notes

This is a proof of concept and not production-ready yet.
