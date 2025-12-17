<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Helper;

trait FlashMessageTrait
{

    private function addFlashErrorMessage(string $message): void
    {
        $_SESSION['error_message'] = $message;
    }

    private function addFlashSuccessMessage(string $message): void
    {
        $_SESSION['success_message'] = $message;
    }
}
