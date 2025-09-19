<?php

use Illuminate\Http\UploadedFile;

if (!function_exists('generateSafeFilename')) {
    /**
     * Generate a safe filename with timestamp and sanitized original name.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     *
     * @return string
     */
    function generateSafeFilename(UploadedFile $uploadedFile): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);

        // Sanitize filename: remove/replace unsafe characters
        $sanitizedBaseName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $baseName);

        return $timestamp . '_' . $sanitizedBaseName . '.' . strtolower($extension);
    }
}
