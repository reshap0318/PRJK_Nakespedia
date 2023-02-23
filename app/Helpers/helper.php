<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
    $qrName = 'qrcode/'.$no_reg.".svg";
    if(!Storage::exists($qrName))
    {
        $qr = QrCode::size(500)->generate(route('homepage.data', $no_reg));
        Storage::put($qrName, $qr);
    }
    return $qrName;
}