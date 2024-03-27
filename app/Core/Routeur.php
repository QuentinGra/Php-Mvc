<?php

namespace App\Core;

class Routeur
{
    public function __construct(
        private array $routes = []
    ) {
    }

    /**
     * Add road in rooteur
     *
     * @param array $route
     * @return self
     */
    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handle(string $url, string $method): void
    {

        // On boucle sur le tableau des routes disponibles
        foreach ($this->routes as $route) {
            // On vérifie si l'url de la route correspond à l'url du navigateur
            // On vérifie également que la méthode HTTP du navigateur est "autorisé" sur la route
            if (
                preg_match("#^" . $route['url'] . "$#", $url, $matches)
                && in_array($method, $route['methods'])
            ) {

                // On récupère le nom du controller dans la route
                $controller = $route['controller'];

                // On récupère le nom de la méthode dans la route
                $action = $route['action'];

                // On instancie le controller
                $controller = new $controller();

                // On récupère les paramètres potentiels de l'url
                $params = array_slice($matches, 1);

                // On éxecue la méthode dans le controller
                $controller->$action(...$params);

                return;
            }
        }

        http_response_code(404);
        echo "<h2>Page Not Found</h2>";
        exit();
    }
}
