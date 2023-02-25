<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

function menuActive(Array $curentPaths, Array $exceptPath = [])
{
    if(count($curentPaths) <= 0) return null; //kalau curent path tidak ada isinya, maka kembalian null

    $path = request()->path();
    if(count($curentPaths) > 1 && in_array($path, $curentPaths)) return 'show'; //kalau curent path bernilai jamak, dan path, maka = sub menu, kembalian show
    if(count($curentPaths) == 1 && in_array($path, $curentPaths)) return 'active'; // kalau curent path
    
    return null;
}

function generateQrCode($no_reg)
{
    $qrName = 'qrcode/'.$no_reg.".png";
    if(!Storage::exists($qrName))
    {
        Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(route('homepage.data', $no_reg))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->build()
            ->saveToFile(Storage::path($qrName));
    }
    return $qrName;
}