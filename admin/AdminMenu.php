<?php

namespace AutoPublish\Admin;

class AdminMenu
{
    private UploadPageController $controller;

    public function __construct(UploadPageController $controller)
    {
        $this->controller = $controller;
    }

    public function register(): void
    {
        add_menu_page(
            'AutoPublish',
            'AutoPublish',
            'manage_options',
            'autopublish',
            [$this->controller, 'render'],
            'dashicons-upload'
        );
    }
}