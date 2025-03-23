<?php

namespace Kirago\BusinessCore\Support\Helpers;

use Illuminate\Support\Str;
final class BcPDFHelper
{


    /**
     * Génère un PDF pour une facture donnée.
     *
     * @param string $filename
     * @param array|null $configs
     * @return array
     *
     * @see \Barryvdh\DomPDF\PDF::loadView()
     * @see \Barryvdh\DomPDF\PDF::setPaper()
     * @see \Dompdf\Canvas::page_text()
     */
    public static function generateStream(string $filename,?array $configs = []): array
    {
        $filename = "$filename.pdf";

        $viewFile = $configs['view']['file'] ?? "pdf.invoices.print";
        $viewData = $configs['view']['data'] ?? [];

        $pdfConfig = $configs['pdf'] ?? [];

        /**
         * @see \Barryvdh\DomPDF\PDF::setPaper()
         */
        $paperFormat = $pdfConfig['paper']['format'] ?? "A4";
        $paperOrientation = $pdfConfig['paper']['orientation'] ?? "portrait";

        /**
         * @see \Dompdf\Canvas::page_text()
         */
        $pageText = $pdfConfig['pageText'] ?? [];

        $pageTextFont = $pageText['font'] ?? 'Arial';
        $pageTextX = $pageText['X'] ?? 15;
        $pageTextY = $pageText['Y'] ?? 25;
        $pageTextSize = $pageText['size'] ?? 8;
        $pageTextLabel = $pageText['label'] ?? __('invoices.page', "Page") . ' {PAGE_NUM} ' . __('invoices.of', "Sur") . ' {PAGE_COUNT}';
        $pageTextColor = $pageText['color'] ?? [140 / 255, 143 / 255, 149 / 255];

        $defaultViewData = [
            'filename' => $filename,
        ];

        $viewData = array_merge($defaultViewData, $viewData);

        /**
         * @var DomPDF
         */
        $pdf = Pdf::loadView($viewFile, $viewData)
                ->setPaper($paperFormat, $paperOrientation);

        $pdf->output();
        $domPdf = $pdf->getDomPDF();
        $canvas = $domPdf->getCanvas();

        $canvas->page_text(
            $pageTextX,
            $canvas->get_height() - $pageTextY,
            $pageTextLabel,
            $pageTextFont,
            $pageTextSize,
            $pageTextColor
        );

        return [$pdf, $filename];
    }

}