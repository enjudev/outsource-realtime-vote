<?php
use App\Models\Lang;
if (!function_exists('Translate')) {
    $variableEn = [];
    $variableVi = [];

    function Translate($key)
    {
        global $variableEn, $variableVi;
        
        $currentLocale = app()->getLocale();
        
        if (empty($variableEn) && $currentLocale == 'en') {
            $variableEn = Lang::get()->pluck('en', 'key')->toArray();
        }
        
        if (!empty($variableEn)) {
            if (array_key_exists($key, $variableEn)) {
                return $variableEn[$key];
            } else {
                return $key;
            }
        }
        
        if (empty($variableVi) && $currentLocale == 'vi') {
            $variableVi = Lang::get()->pluck('vi', 'key')->toArray();
        }
        
        if (!empty($variableVi)) {
            if (array_key_exists($key, $variableVi)) {
                return $variableVi[$key];
            } else {
                return $key;
            }
        }
    }
}