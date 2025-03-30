<?php

namespace TestImgApi\Contracts;

interface ImageInterface
{

    public function uploadImage($file);

    public function cropImage(int $width = 70, int $height = 70);

    public function optimizeImage();
}
