<?php

return [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'bucket' => env('AWS_S3_BUCKET'),
    'region' => env('AWS_S3_REGION'),
];
