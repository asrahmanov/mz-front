<?php


namespace App\Controller\Admin;


use App\Entity\File;
use Gedmo\Uploadable\FileInfo\FileInfoArray;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/admin/file", methods={"POST"})
     */
    public function post(Request $request, UrlHelper $urlHelper) : JsonResponse
    {
        $targetDir = 'uploads';
        $uploadedFile = $request->files->getIterator()->current();

        if(! $uploadedFile){
            return new JsonResponse(['status' => 'success']);
        }

        $newFilename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
        $r = $uploadedFile->move($targetDir, $newFilename);

        return new JsonResponse([
            'status' => 'success',
            'path' => '/'.$r->getPathname(),
        ]);
    }
}
