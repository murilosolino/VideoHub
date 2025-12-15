<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Helper;

trait FlashMessageTrait
{

    private function addFlashErrorMessage(string $message): void
    {
        $_SESSION['error_message'] = $message;
    }
}
