<?php

namespace App\Controllers;

use App\View\View;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    public function __construct()
    {
        // Создаем объект View
        $this->view = new View(__DIR__ . '/../../../templates');
    }
}
