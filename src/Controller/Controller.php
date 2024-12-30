<?php
namespace Espresso\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This class should be used as the base class for all controllers.
 */
class Controller extends Response
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Wrapper method for Response::prepare() and Response::setContent()
     *
     * @param Request $request
     * @param ?string $content
     *
     * @return void
     */
    protected function renderContent(Request $request, ?string $content) : void
    {
        $this->prepare($request);
        $this->setContent($content);
    }

    public function index(?Request $request) : Response
    {
        $this->renderContent($request, "<p>Index</p>");
        return $this->send();
    }

    public function other(?Request $request) : Response
    {
        $this->renderContent($request, "<p>Other</p>");
        return $this->send();
    }
}

