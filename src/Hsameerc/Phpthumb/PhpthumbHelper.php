<?php
/**
 * Created by Sameer HUmagain
 * Date: 19/02/16
 * Time: 11.00
 *
 * This is a helper method to be used in Blade' templates.
 *
 * Add this to your alias:
 *
 * 'phpThumb'  => 'Hsameerc\Phpthumb\PhpthumbHelper',
 *
 * Usage:
 *
 * {{phpThumb::get('assets/images/laravel/logo.png', 300, 200)}}
 *
 */

namespace Hsameerc\Phpthumb;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class PhpthumbHelper {

    static function get($img, $w = "", $h = "", $crop = true, $params = array()){

        $fullPath = public_path().'/'.$img;
        if(!File::exists($fullPath)) return false;

        $format = '';
        $width = '';
        $htmlWidth = '';
        $height = '';
        $htmlHeight = '';
        $filter = "";
        $method = '';
        $lazyParams = '';

        $ext = File::extension($fullPath);
        if ($ext == 'png') {
            $firstBytes = @file_get_contents($fullPath, false, null, 25, 1);
            if(ord($firstBytes) & 4){
                $format = "f=png"; //for transparent pngs
            }
        }

        if($w){
            $width = 'w='.$w;
            $htmlWidth = 'width="'.$w.'"';
        }

        if($h){
            $height = 'h='.$h;
            $htmlHeight = 'height="'.$h.'"';
        }

        if (count($params) > 0){
            $filter = implode('&', $params); //eg: fltr[]=gray
        }

        if ($w != "" && $h != ""){
            if($crop){
                $method = 'zc=1';
            } else {
                $method = 'far=1&bg=FFFFFF';
            }
        }

        $image = 'src=' . $img;

        $optionsSlices = array($method, $width, $height, $filter, $image, $format);
        $options = implode('&', array_filter($optionsSlices));
        $src = Url::to('/phpthumb') . "?" .$options;

        $htmlOptionsSlices = array($htmlWidth, $htmlHeight, $lazyParams);
        $htmlOptions = implode(' ', array_filter($htmlOptionsSlices));
        return '<img src="'.$src.'" '.$htmlOptions.' />';
    }

}