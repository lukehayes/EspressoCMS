<?php
namespace App\Controller;

use \Espresso\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class should be used as the base class for all controllers.
 */
class SiteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    #[\Override]
    public function index(?Request $request) : Response
    {
        // TODO Implement Twig templating engine.
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
                <meta charset="UTF-8">
                <title>Test Page</title>
        </head>
        <body>

            <p>Loaded</p>
                
        </body>
        </html>
        HTML;

        $this->renderContent($request, $html);

        return $this->send();
    }
}

