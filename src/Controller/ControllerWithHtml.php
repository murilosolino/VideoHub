<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

abstract class ControllerWithHtml implements Controller
{

    private const TEMPLATE_PATH = __DIR__ . '/../../views/';

    protected function renderTemplate(string $template, array $context = []): string
    {
        extract($context);
        ob_start();
        require_once self::TEMPLATE_PATH . $template . '.php';
        return ob_get_clean();
    }
}
