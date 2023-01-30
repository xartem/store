<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerImageProvider extends Base
{
    public function loremflickr(string $dir = '', $disk = 'public', int $width = 500, int $height = 300): string
    {
        $name = Str::uuid() . '.jpg';
        $path = $dir .'/'. $name;

        Storage::disk($disk)->put($path, file_get_contents("https://loremflickr.com/$width/$height"));

        return '/storage/' . $path;
    }
}