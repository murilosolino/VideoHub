<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Entity;

class CheckUploadArquivo
{

    private const UPLOAD_PATH = __DIR__ . "/../../public/img/uploads/";

    public function __construct() {}


    public function moveUploadFile(string $chave): ?string
    {
        if (array_key_exists($chave, $_FILES) && $_FILES[$chave]["error"] === UPLOAD_ERR_OK) {
            $fileName = basename($_FILES[$chave]['name']);
            $uploadPath = self::UPLOAD_PATH . $fileName;
            move_uploaded_file($_FILES[$chave]['tmp_name'], $uploadPath);
            return "/img/uploads/" . $fileName;
        }

        return null;
    }
}
