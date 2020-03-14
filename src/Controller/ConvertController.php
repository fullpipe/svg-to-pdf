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
    /**
     * @Route("/")
     */
    public function index(Request $request, PdfGenerator $generator)
    {
        if ('OPTIONS' === $request->getMethod()) {
            return new Response('', 204, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, OPTIONS',
                'Access-Control-Allow-Headers' => 'X-User-Token, Keep-Alive, User-Agent, X-Requested-With, If-Modified-Since, Cache-Control, Content-Type',
                'Access-Control-Max-Age' => 1728000,
                'Content-Type' => 'text/plain charset=UTF-8',
                'Content-Length' => 0,
            ]);
        }

        //todo: form validation
        $toPdf = new ToPdf();
        $toPdf->setSvg($request->get('svg'));
        $toPdf->setWidth($request->get('width'));
        $toPdf->setHeight($request->get('height'));

        $response = new Response($generator->generate($toPdf));
        $response->headers->set('Content-type', 'application/pdf');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
