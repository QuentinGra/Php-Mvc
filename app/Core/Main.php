<?php

namespace App\Core;

/**
 * Start App
 */
class Main
{
    public function __construct(
        private Routeur $routeur = new Routeur(),
    ) {
    }
    public function start(): void
    {
        $uri = $_GET['q'];

        if (!empty($uri) && $uri !== '/' && $uri[-1] === '/') {
            $uri = substr($uri, 0, -1);

            http_response_code(301);
            header("Location: /$uri");
            exit();
        }

        $this->initRouteur();

        $this->routeur->handle($uri, $_SERVER['REQUEST_METHOD']);
    }

    private function initRouteur(): void
    {
        $files = glob(realpath(ROOT . '/Controllers') . '/*.php');
        $files2 = glob(realpath(ROOT . '/Controllers') . '/**/*.php');

        $files = array_merge_recursive($files, $files2);
        var_dump($files);
    }
}
