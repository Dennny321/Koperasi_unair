<?php

return [
    'mode' => env('PRINTER_TYPE', 'windows'),
    'device' => env('PRINTER_DEVICE', 'POS58'),
    'name' => env('PRINTER_NAME', 'POS58'),
    'host' => env('PRINTER_HOST', '192.168.1.200'),
    'port' => env('PRINTER_PORT', 9100),
    'agent_token' => env('PRINT_AGENT_TOKEN', ''),
];