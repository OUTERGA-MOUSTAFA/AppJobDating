
<?php

namespace App\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $viewPath;

    
    public function renders(string $view, array $data = [])
    {
        $this->viewPath = "../views/{$view}.php";

    // Extraction des donné
        extract($data);

        ob_start();
        require $this->viewPath;
        $content = ob_get_clean();

    
    }

     private static ?Environment $twig = null;

    public static function render(string $template, array $data = []): void
    {
        if (self::$twig === null) {
            $loader = new FilesystemLoader('../views');

            self::$twig = new Environment($loader, [
                'cache' => false, // __DIR__ . '/../../storage/cache' in prod
                'debug' => true,
            ]);
        }

        echo self::$twig->render($template . '.twig', $data);
    }

    
}
