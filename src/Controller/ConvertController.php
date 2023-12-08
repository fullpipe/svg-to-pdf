<?php

namespace App\Controller;

use App\PdfGenerator;
use App\ToPdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConvertController extends AbstractController
{
    #[Route('/')]
    public function index(Request $request, PdfGenerator $pdfGenerator): Response
    {
        // todo: form validation
        $toPdf = new ToPdf();
        $toPdf->setSvg($request->get('svg'));
        $toPdf->setWidth($request->get('width'));
        $toPdf->setHeight($request->get('height'));

        $response = new Response($pdfGenerator->generate($toPdf));
        $response->headers->set('Content-type', 'application/pdf');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
