<?php

/*
|--------------------------------------------------------------------------
| Media Processing Configuration
|--------------------------------------------------------------------------
|
| Controls how uploaded media is processed.
| - extract_video_metadata: When true, attempts to read video width/height/
|   duration using ffmpeg/ffprobe. When false, uploads still succeed but
|   metadata defaults to zeros. Toggle via MEDIA_EXTRACT_VIDEO_METADATA.
| - ffmpeg/ffprobe binaries: Optional explicit paths to the system binaries.
|   Configure via FFMPEG_BINARIES and FFPROBE_BINARIES when enabling
|   metadata extraction or when binaries are not in the default PATH.
|
*/

return [
    'extract_video_metadata' => env('MEDIA_EXTRACT_VIDEO_METADATA', false),

    'ffmpeg' => [
        'binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),
    ],

    'ffprobe' => [
        'binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),
    ],
];


