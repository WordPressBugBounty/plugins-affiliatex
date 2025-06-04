# Codebase Overview

This document provides a high‑level summary of how the AffiliateX plugin is organized.

## General Structure

- **`affiliatex.php`** is the main plugin entry point. It initializes the Freemius SDK for licensing, loads Composer autoload files, defines constants, and bootstraps the core `AffiliateX` class. If a Pro version is installed, it loads that as well.
- **`includes/AffiliateX.php`** implements a singleton that sets up admin hooks, public hooks, block registration, internationalization, and optional Elementor widgets.
- **Blocks** are built with Gutenberg/React under **`src/blocks/`**. Each block has a PHP class extending `BaseBlock` and a React counterpart bundled with Webpack. Render templates live in **`templates/blocks/`**.
- **Amazon integration** resides in **`includes/amazon/`** where credentials are managed and the Product Advertising API requests are implemented.
- The **Pro edition** mirrors the free version's structure inside **`/pro`**, providing additional blocks and features.
- JavaScript assets are bundled with **Webpack** (`webpack.config.js`). Admin SPA files are in **`src/admin/`** and build output goes to `build/` or `pro/build/`.
- **Testing** is based on WordPress's PHPUnit setup with sample tests under **`tests/`**.

## Pointers for Further Learning

1. **WordPress plugin architecture** – learn about hooks such as `add_action` and `register_block_type_from_metadata`.
2. **Gutenberg block development** – explore the blocks in `src/blocks/` and the accompanying PHP templates.
3. **React/webpack workflow** – see `webpack.config.js` for how scripts are bundled.
4. **Freemius SDK** – understand how `affiliatex_fs()` initializes licensing in `affiliatex.php`.
5. **Amazon Product Advertising API** – inspect `includes/amazon/api/` for request signing and credential validation.
6. **Elementor integration** – optional widgets are located in `includes/elementor/`.

