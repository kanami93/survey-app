<?php

namespace App\File\Writer;

use Josegonzalez\Upload\File\Writer\DefaultWriter;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\FilesystemException;

/**
 * App Writer Class
 *
 */
class AppWriter extends DefaultWriter
{
    /**
     * Writes a set of files to an output
     *
     * @param \League\Flysystem\FilesystemOperator $filesystem a filesystem wrapper
     * @param string $file a full path to a temp file
     * @param string $path that path to which the file should be written
     * @return bool
     */
    public function writeFile(FilesystemOperator $filesystem, $file, $path): bool
    {
        $stream = @fopen($file, 'r');
        if ($stream === false) {
            return false;
        }

        $config = [
            'ContentType' => $this->data->getClientMediaType(),
        ];

        $success = false;
        $tempPath = $path . '.temp';
        $this->deletePath($filesystem, $tempPath);
        try {
            $filesystem->writeStream($tempPath, $stream, $config);
            $this->deletePath($filesystem, $path);
            try {
                $filesystem->move($tempPath, $path);
                $success = true;
            } catch (FilesystemException $e) {
                // noop
            }
        } catch (FilesystemException $e) {
            // noop
        }
        $this->deletePath($filesystem, $tempPath);
        is_resource($stream) && fclose($stream);

        return $success;
    }
}
