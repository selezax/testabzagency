<?php

namespace TestImgApi\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;
use TestImgApi\Contracts\ImageInterface;

use Spatie\Image\Image;
use Tinify\Tinify;

/**
 * @props string original
 * @props string cropped
 * @props string optimized
 */
class ImageService implements ImageInterface
{
    const UPLOAD_ORIGIN = 'uploads/originals';
    const UPLOAD_CROP = 'uploads/cropped';
    const UPLOAD_OPTIMIZED = 'uploads/optimized';
    const OUT_EXT = '.jpg';

    private string $originalPath;
    private string $croppedPath;
    private string $optimizedPath;

    public function uploadImage($file)
    {
        $originalFileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $this->originalPath = (string)Storage::putFileAs(self::UPLOAD_ORIGIN, $file, $originalFileName, 'public');
        return $this;
    }

    public function cropImage(int $width = 70, int $height = 70)
    {
        $croppedFileName = uniqid() . self::OUT_EXT;
        $this->croppedPath = self::UPLOAD_CROP . DIRECTORY_SEPARATOR . $croppedFileName;
        $fullCroppedPath = Storage::disk('public')->path($this->croppedPath);

        Image::load(Storage::disk('public')->path($this->originalPath))
            ->fit(Fit::Crop, $width, $height)
            ->save($fullCroppedPath);
        return $this;
    }

    public function optimizeImage()
    {
        Tinify::setKey(config('services.tinify.key'));

        $source = \Tinify\fromFile(Storage::disk('public')->path($this->croppedPath));

        $optimizedFileName = uniqid() . self::OUT_EXT;
        $optimizedRelativePath = self::UPLOAD_OPTIMIZED . DIRECTORY_SEPARATOR . $optimizedFileName;

        $optimizedContent = $source->toBuffer();
        Storage::disk('public')->put($optimizedRelativePath, $optimizedContent);

        $this->optimizedPath = $optimizedRelativePath;

        return $this;
    }

    public function __get(string $name)
    {
        return match ($name) {
            'original' => $this->originalPath,
            'cropped' => $this->croppedPath,
            'optimized' => $this->optimizedPath,
            default => 'undefined',
        };
    }
}
