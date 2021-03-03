<?php

namespace App\Ship\Core\Traits\TestsTraits\PhpUnit;

use Illuminate\Http\UploadedFile;

/**
 * Class TestsUploadHelperTrait
 *
 * Tests helper for uploading files.
 */
trait TestsUploadHelperTrait
{
    /**
     * @param string   $imageName
     * @param string   $stubDirPath
     * @param string   $mimeType
     * @param null|int $size
     *
     * @return UploadedFile
     */
    public function getTestingImage(string $imageName, string $stubDirPath, string $mimeType = 'image/jpeg', ?int $size = null)
    {
        return $this->getTestingFile($imageName, $stubDirPath, $mimeType, $size);
    }

    /**
     * @param string   $fileName
     * @param string   $stubDirPath
     * @param string   $mimeType
     * @param null|int $size
     *
     * @return UploadedFile
     */
    public function getTestingFile(string $fileName, string $stubDirPath, string $mimeType = 'text/plain', ?int $size = null)
    {
        $file = $stubDirPath . $fileName;

        return new UploadedFile($file, $fileName, $mimeType, null, true); // null = null | $testMode = true
    }
}
