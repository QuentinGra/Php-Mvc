<?php

namespace App\Core;

use ErrorException;
use ReflectionMethod;

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
        session_start();

        $uri = $_SERVER['REQUEST_URI'];

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

        foreach ($files as $file) {
            $file = substr($file, 1);
            $file = str_replace('/', '\\', $file);
            $file = str_replace('.php', '', $file);

            $class = ucfirst($file);

            if (!class_exists($class)) {
                throw new ErrorException("La class $class n'existe pas, vérifier le namespace ou le nom du fichier");
            }

            $methods = get_class_methods($class);

            foreach ($methods as $method) {
                $attributes = (new ReflectionMethod($class, $method))->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $route->setController($class)->setAction($method);

                    $this->routeur->addRoute([
                        'url' => $route->getUrl(),
                        'name' => $route->getName(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                        'methods' => $route->getMethods(),
                    ]);
                }
            }
        }
    }
}
