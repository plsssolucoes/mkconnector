<?php

/*
 * Variaveis setadas no .env da aplicacao para conexao com Router Board
 *
 */
return [
    'connections' => [
        
        'pppoe' => [
            'mk-ip' => env('MK_IP'),
            'mk-user' => env('MK_USERNAME'),
            'mk-password' => env("MK_PASSWORD")
        ],

        'hotspot' => [
            'mk-ip' => env('MK_HOTSPOT_IP'),
            'mk-user' => env('MK_HOTSPOT_USERNAME'),
            'mk-password' => env("MK_HOTSPOT_PASSWORD")

        ]
    ]
];
