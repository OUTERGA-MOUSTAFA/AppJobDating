<?php

namespace App\app\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $viewPath;

    /**
     * Render PHP view
     */
    public function renderPhp(string $view, array $data = [])
    {
        $this->viewPath = __DIR__ . "/../views/{$view}.php";
        
        extract($data);
        
        ob_start();
        require $this->viewPath;
        $content = ob_get_clean();
        
        echo $content;
    }

    /**
     * Render Twig template
     */
    private static ?Environment $twig = null;

    public static function render(string $template, array $data = []): void
    {
        if (self::$twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../views');

            self::$twig = new Environment($loader, [
                'cache' => false,
                'debug' => true,
            ]);
        }

        echo self::$twig->render($template . '.twig', $data);
    }
}
