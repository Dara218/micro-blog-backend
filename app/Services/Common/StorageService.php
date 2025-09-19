<?php

namespace App\Services\Common;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $storage;

    /**
     * Channel for logging
     *
     * @var string
     */
    protected $channel = 's3';

    /**
     * Setup the service.
     */
    public function __construct()
    {
        $this->storage = Storage::disk('s3');
    }

    /**
     * Saves the file contents to storage in the specified directory and filename.
     *
     * @param string $filepath The file path of the file
     * @param mixed $contents The file content to be uploaded
     * @param ?mixed $options
     *
     * @return bool
     */
    public function put(
        string $filepath,
        mixed $contents,
        mixed $options = [],
    ): bool {
        try {
            $result = $this->storage->put(
                $filepath,
                $contents,
                $options,
            );

            return $result;
        } catch (\Exception $error) {
            LogService::error(
                'Error Uploading file to storage',
                [
                    'error' => $error->getMessage(),
                    'trace' => $error->getTraceAsString(),
                ],
                $this->channel,
            );

            return false;
        }
    }

    /**
     * Checks if a file exists given a filepath.
     *
     * @param string $filepath
     *
     * @return bool
     */
    public function exists(string $filepath): bool
    {
        $result = $this->storage->exists($filepath);

        return $result;
    }

    /**
     * Gets the contents of a file. If a file doesn't exist, returns null.
     *
     * @param string $filepath
     *
     * @return string|null
     */
    public function get(string $filepath): string|null
    {
        try {
            $result = $this->storage->get($filepath);

            return $result;
        } catch (\Exception $e) {
            LogService::error(
                'Error getting file from storage',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                $this->channel,
            );

            return null;
        }
    }

    /**
     * Attempts to delete file(s) at the given filepath(s).
     * Input can be a string (for single file) or an array (for multiple files).
     *
     * @param array<string>|string $filepaths
     *
     * @return bool
     */
    public function delete(array|string $filepaths): bool
    {
        try {
            $result = $this->storage->delete($filepaths);

            return $result;
        } catch (\Exception $e) {
            LogService::error(
                'Error deleting file from storage',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                $this->channel,
            );

            return false;
        }
    }
}
