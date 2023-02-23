<?php

namespace Support\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasThumbnail
{
    protected function thumbnailDirectory(): string
    {
        return Str::of((new \ReflectionClass($this))->getShortName())
            ->plural()
            ->lower();
    }

    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        return route('thumbnail', [
            'directory' => $this->thumbnailDirectory(),
            'method' => $method,
            'size' => $size,
            'file' => File::basename($this->{$this->thumbnailColumn()}),
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
