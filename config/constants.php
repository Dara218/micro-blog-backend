<?php

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
|
| This file is used to define static, global values that are shared
| across the application. You can store configuration constants here
| such as default values, limits, or system flags.
|
| Example:
|   'default_timezone' => 'Asia/Tokyo',
|   'max_upload_size' => 2048,
|
*/
return [
    'default' => [
        'seeder_count' => 10,
    ],
    'validation' => [
        'max_video_size' => 25000, // in KB
        'max_image_size' => 5000, // in KB
    ],
];
