<?php

function menuActive(Array $curentPaths, Array $exceptPath = [])
{
    if(count($curentPaths) <= 0) return null; //kalau curent path tidak ada isinya, maka kembalian null

    $path = request()->path();
    if(count($curentPaths) > 1 && in_array($path, $curentPaths)) return 'show'; //kalau curent path bernilai jamak, dan path, maka = sub menu, kembalian show
    if(count($curentPaths) == 1 && in_array($path, $curentPaths)) return 'active'; // kalau curent path
    
    return null;
}