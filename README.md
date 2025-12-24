# 🦖 KT (KaijuTranslator)

**The 100% Plug-and-Play PHP Translator** - *Because life is too short for .htaccess.*

KT converts your existing PHP website to multilingual ( `/en/`, `/fr/` ) by creating physical subfolders and translating content with AI. It's designed to be completely isolated: **if you delete the `KT/` folder, your site returns to its original state.**

## ✨ Features

- **Total Isolation**: Everything KT needs is inside the `KT/` folder.
- **Physical Subfolders**: Creates real, crawlable directories.
- **SEO Ready**: Auto-generates `hreflang` and `sitemap.xml`.
- **"Dummy Proof"**: Interactive setup and uninstaller.

## 🚀 Installation

### 1. Drop the Folder

Copy the `KT/` folder to your website's root directory.

### 2. Run Setup

Open your terminal in the `KT` folder and run:

```bash
php KT/setup.php
```

Follow the wizard to set your API Key. It will create `KT/kaiju-config.php`.

### 3. Build

Generate your language folders and stubs:

```bash
php KT/cli/build.php
```

### 4. Direct Injection

Include the widget in your `header.php` (or global template):

```php
<?php include __DIR__ . '/KT/widget.php'; ?>
```

## 🗑 Uninstallation

Need to remove it? Just visit:
`yoursite.com/KT/uninstall.php?pass=your_password`
(Default password: `kaiju123`)

This will delete all `/en/`, `/fr/` folders and sitemaps. Finally, just delete the `KT/` folder.

## 📂 Structure

```text
/
├── KT/                   # Everything is here!
│   ├── docs/             # Documentation
│   ├── tests/            # Tests
│   ├── kaiju-config.php  # Your config
│   └── uninstall.php     # Safety first
└── index.php             # Your site (untouched)
```
