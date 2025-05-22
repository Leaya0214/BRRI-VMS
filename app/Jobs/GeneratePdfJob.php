<?php

// app/Jobs/GeneratePdfJob.php
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneratePdfJob implements ShouldQueue
{
    use Queueable;
    protected $requisition;

    public function __construct($requisition)
    {
        $this->requisition = $requisition;
    }

    public function handle()
    {
        $data = ['requisition' => $this->requisition, 'errors' => new ViewErrorBag()];
        $view = view('pdf.requisition', $data)->render();
        $pdf = PDF::loadHTML($view);
        $pdf->setPaper('A4', 'portrait');
        $filePath = 'pdfs/requisition_' . $this->requisition->id . '.pdf';
        Storage::put($filePath, $pdf->output());
    }
}


?>
