<?php

namespace App;

use Dompdf\Dompdf;

class PdfGenerator
{
    public function generate(ToPdf $toPdf): ?string
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');
        @$doc->loadHTML($this->html($toPdf->getSvg()));

        $svg = $doc->getElementsByTagName('svg')->item(0);
        if (!$svg) {
            throw new \Exception('No svg');
        }

        for ($i = 0; $i < $svg->attributes->length; ++$i) {
            switch ($svg->attributes->item($i)->nodeName) {
                case 'width':
                    $toPdf->setWidth($toPdf->getWidth() ?? (float) $svg->attributes->item($i)->nodeValue);
                    break;
                case 'height':
                    $toPdf->setHeight($toPdf->getHeight() ?? (float) $svg->attributes->item($i)->nodeValue);
                    break;
            }
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->htmlBase64($toPdf->getSvg()));
        $dompdf->getOptions()->setDpi(25.4);

        $w = $toPdf->getWidth() * (72 / 25.4);
        $h = $toPdf->getHeight() * (72 / 25.4);
        $dompdf->setPaper([0, 0, $w, $h]);
        $dompdf->render();

        return $dompdf->output();
    }

    private function htmlBase64($svg)
    {
        return '<!DOCTYPE html>
            <html>
                <head>
                    <style>@page { margin: 0px; }</style>
                </head>
                <body>
                    <img src="data:image/svg+xml;base64,'.\base64_encode($svg).'" />
                </body>
            </html>';
    }

    private function html($svg)
    {
        return '<!DOCTYPE html>
            <html>
                <head>
                    <style>@page { margin: 0px; }</style>
                </head>
                <body>'.$svg.'</body>
            </html>';
    }
}
