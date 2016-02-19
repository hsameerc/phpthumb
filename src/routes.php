<?php  
use Hsameerc\Plassets\Plassets;

use Illuminate\Support\Facades\Route;

Route::get('/phpthumb', function(){
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 3600 * 24 * 30)); //One month
    if(isset($_GET['src'])) $_GET['src'] = public_path() . "/" . $_GET['src'];
    require __DIR__ . '/phpthumb/phpThumb.php';
});