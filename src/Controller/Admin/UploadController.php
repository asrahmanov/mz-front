<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/admin/tinymce/upload", methods={"POST"}, name="tinymce_upload")
     */
    public function tinymce(Request $request): JsonResponse
    {
        $targetDir = 'uploads';
        if ($file = $request->files->get('file')) {
            $newFilename = uniqid() . '.' . $file->getClientOriginalExtension();
            $r = $file->move($targetDir, $newFilename);
            return new JsonResponse(['location' => '/' . $r->getPathname()]);
        }
        throw new \HttpRuntimeException();
    }
}
