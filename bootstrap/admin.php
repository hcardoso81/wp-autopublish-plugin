<?php

namespace AutoPublish\Bootstrap;

use AutoPublish\Admin\AdminMenu;
use AutoPublish\Admin\UploadPageController;
use AutoPublish\Domain\HtmlImporter;

// Requires
require_once AUTOPUBLISH_PATH . 'admin/AdminMenu.php';
require_once AUTOPUBLISH_PATH . 'admin/UploadPageController.php';
require_once AUTOPUBLISH_PATH . 'domain/HtmlImporter.php';
require_once AUTOPUBLISH_PATH . 'infrastructure/logging/Logger.php';

add_action('admin_menu', function () {

    $importer = new HtmlImporter();
    $controller = new UploadPageController($importer);

    $menu = new AdminMenu($controller);
    $menu->register();
});