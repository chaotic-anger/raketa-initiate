<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\View\DTO;


class ErrorDto
{
    public string $error;

    public static function create(string $error): self
    {
        $dto = new self();
        $dto->error = $error;

        return $dto;
    }
}