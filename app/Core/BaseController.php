<?php

namespace App\Core;

abstract class BaseController
{

    /**
     * Render the views of a page
     *
     * @param string $path The path of the view to render
     * @return void
     */
    protected function render(string $path): void
    {
        ob_start();
        require_once ROOT . '/Views/' . $path;
        $content = ob_get_clean();

        require_once ROOT . '/Views/base.php';
    }
}
