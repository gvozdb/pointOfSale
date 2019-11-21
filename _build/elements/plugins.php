<?php

return [
    'pointsOfSale' => [
        'file' => 'system',
        'description' => '',
        'events' => [
            /**
             * MODX
             */

            // 'OnMODXInit' => ['priority' => 99999],
            'OnDocFormRender' => [],


            /**
             * miniShop2
             */

            // Product
            'msOnGetProductPrice' => ['priority' => 9999999],
        ],
    ],
];