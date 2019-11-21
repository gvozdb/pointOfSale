<?php
return [
    'map' => [
        'msProductData' => require_once 'msproductdata.inc.php',
        'msOrder' => require_once 'msorder.inc.php',
    ],
    'manager' => [
        'msProductData' => MODX_ASSETS_URL . 'components/pointsofsale/js/mgr/ms2plugin/msproductdata.js',
    ],
];