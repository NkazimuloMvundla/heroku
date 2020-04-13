<?php

Validator::extend('upload_count', function($attribute, $value, $parameters)
{   
    $files = Input::file($parameters[0]);

    return (count($files) <= $parameters[1]) ? true : false;
});

