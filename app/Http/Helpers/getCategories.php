<?php

if (!function_exists('productCategory')) {
function productCategory()
{
        $pCats = \App\productCategory::all();
        return $pCats;
}
}


