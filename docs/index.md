# Cellular

Cellular allows CodeIgniter 4 developers to create interactive applications without the need for custom javascript solutions. Instead, it extends the View Cell concept into Live Cells that can be automatically interactive without leaving the CodeIgniter environment.

## Installation

Cellular is installed via Composer.

```cli
composer require lonnieezell/cellular
```

Once installed, you need to load the scripts and styles into your view layout so it will be loaded and ready on all pages that need it. If you are not using view layouts, then it needs to be manually included in every page that requires Live Cell support.

```php
// In the page head:
<?= cellular_styles() ?>

// Just before page close:
<?= cellular_scripts() ?>
```

## Inserting a Live Cell

Live Cells are inserted within views using the `cell()` helper method. This takes name of the Cell as the first parameter. Any additional parameters can be supplied in the same manner as for Controlled Cells.

```php
<?= live_cell('Todo') ?>
```
