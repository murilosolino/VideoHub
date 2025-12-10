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

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES[$chave]['tmp_name']);

            if (str_starts_with($mimeType, 'image/')) {
                $fileName = uniqid("upload_") . "_" . $this->slug(basename($_FILES[$chave]['name']));
                $uploadPath = self::UPLOAD_PATH . $fileName;
                move_uploaded_file($_FILES[$chave]['tmp_name'], $uploadPath);
                return "/img/uploads/" . $fileName;
            }
        }

        return null;
    }

    private function slug(string $title): string
    {
        $slug = strtolower($title);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('/-+/', '-', $slug);

        return $slug;
    }
}
