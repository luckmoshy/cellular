<?php

if (! defined('cellular_scripts')) {

    /**
     * Ensures that the scripts are loaded in the page.
     * Should be called from any view that will use Cellular.
     * Best used within a view layout so it is loaded on every page.
     */
    function cellular_scripts() {
        $html = CI_DEBUG
            ? "<!-- Cellular Scripts -->\n"
            : '';

        // Load Alpine and their Morph plugin
        $html .= '<script defer src="https://unpkg.com/@alpinejs/morph@3.x.x/dist/cdn.min.js"></script>'. "\n";
        $html .= '<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>'. "\n";

        return $html . '<script src="' . site_url('_cellular/scripts') . '"></script>';
    }
}

if (! defined('cellular_styles')) {

    /**
     * Ensures that the styles are loaded in the page.
     * Should be called from any view that will use Cellular.
     * Best used within a view layout so it is loaded on every page.
     */
    function cellular_styles() {
        $html = CI_DEBUG
            ? "<!-- Cellular Styles -->\n"
            : '';

        return $html . '<link rel="stylesheet" href="' . site_url('_cellular/styles') . '">';
    }
}

if (! defined('live_cell')) {

    /**
     * Returns the Cellular instance.
     */
    function live_cell(string $cellName, $params = null) {
        return service('cellular')->initialRender($cellName, $params);
    }
}
