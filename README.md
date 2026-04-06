# WP AutoPublish Plugin

WordPress plugin that allows importing content from Google Docs and automatically creating draft posts.

## 🚀 Features (POC v2)

- Import content directly from a Google Docs URL
- Automatically fetch and convert document to HTML
- Download and upload images to WordPress Media Library
- Replace external image URLs with local WordPress URLs
- Create draft posts automatically

## 🧱 Architecture

The plugin follows a clean architecture approach:

- `admin/` → WordPress admin UI and controllers
- `domain/` → Business logic (importers, processors)
- `infrastructure/` → Logging and external integrations
- `views/` → UI templates
- `bootstrap/` → Plugin initialization and wiring

### Main Components

- `GoogleDocFetcher` → Fetches HTML from Google Docs
- `HtmlImporter` → Processes HTML and creates WordPress posts

## 📦 Installation

1. Clone the repository into `/wp-content/plugins/`
2. Activate the plugin from WordPress admin
3. Go to **AutoPublish** menu

## 🧪 Usage

1. Open a Google Docs document
2. Make sure it is publicly accessible ("Anyone with the link")
3. Copy the document URL
4. Paste it into the plugin input
5. Click **Import and create draft**
6. Edit the generated post in WordPress

## ⚠️ Requirements

- Google Docs document must be publicly accessible
- WordPress must allow outbound HTTP requests (`wp_remote_get`)

## 🔜 Roadmap

- [ ] HTML cleanup (remove inline styles and unnecessary tags)
- [ ] Convert content to Gutenberg blocks
- [ ] Extract metadata (title, excerpt, featured image)
- [ ] Category and tag automation
- [ ] Mailchimp integration
- [ ] Multiple document import (batch)

## ⚠️ Notes

This is a proof of concept and not production-ready yet.