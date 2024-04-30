<?php

namespace App\Traits;

trait ServiceResponse
{

    public function response(string $message, $content = null, bool $status = true): array
    {
        return [
            'status'    => $status,
            'message'   => $message,
            'content'   => $content
        ];
    }
}
