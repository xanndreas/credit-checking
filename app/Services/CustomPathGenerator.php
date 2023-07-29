<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media) : string
    {
        $mediaPath = $media->id;

        $mediaPath .= match ($media->collection_name) {
            'id_photos' => '/KTP/',
            'kk_photos' => '/KK/',
            'npwp_photos' => '/NPWP/',
            'other_photos' => '/Others/',
            'attachments' => '/Attachments/',
        };

        return $mediaPath;
    }

    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
