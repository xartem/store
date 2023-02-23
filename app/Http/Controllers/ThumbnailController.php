<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __invoke(
        string $directory,
        string $method,
        string $size,
        string $file
    ): BinaryFileResponse {
        abort_if(
            ! in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk('images');

        $real_path = "$directory/$file";
        $new_path = "$directory/$method/$size";
        $result_path = "$new_path/$file";

        if (! $storage->exists($new_path)) {
            $storage->makeDirectory($new_path);
        }

        if (! $storage->exists($result_path)) {
            $image = Image::make($storage->path($real_path));
            [$w, $h] = explode('x', $size);

            $image->{$method}($w, $h);

            $image->save($storage->path($result_path));
        }

        return response()->file($storage->path($result_path));
    }
}
