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
    protected function render(string $path, array $data = []): void
    {
        extract($data);

        ob_start();
        require_once ROOT . '/Views/' . $path;
        $content = ob_get_clean();

        require_once ROOT . '/Views/base.php';
    }

    /**
     * Redirect
     *
     * @param string $url
     * @param integer $code - default 302
     * @return void
     */
    protected function redirect(string $url, int $code = 302): void
    {
        http_response_code($code);
        header("Location: $url");
        exit();
    }
}
