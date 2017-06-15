<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => base_path(' vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

);
