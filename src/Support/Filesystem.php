<?php

declare(strict_types=1);

namespace Pair\Support;

/**
 * @internal
 */
final readonly class Filesystem
{
    /**
     * Deletes a directory and all its contents recursively.
     */
    public static function remove(string $path): void
    {
        if (! is_dir($path)) {
            if (file_exists($path)) {
                unlink($path);
            }

            return;
        }

        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file) {
            $fullPath = $path.DIRECTORY_SEPARATOR.$file;

            if (is_dir($fullPath)) {
                self::remove($fullPath);
            } else {
                unlink($fullPath);
            }
        }

        rmdir($path);
    }

    /**
     * Creates directory.
     */
    public static function createDirectory(string $path): void
    {
        mkdir($path, 0755, true);
    }

    /**
     * Deletes all directory files.
     */
    public static function truncateDirectory(string $path): void
    {
        foreach (glob($path.'/*') ?: [] as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public static function copyDirectoryFiles(string $from, string $to): void
    {
        foreach (glob($from.'/*') ?: [] as $file) {
            if (is_file($file)) {
                copy($file, $to.'/'.basename($file));
            }
        }
    }

    public static function copyDirectoryFilesForAgent(string $from, string $to, \Pair\Contracts\Agent $agent): void
    {
        foreach (glob($from.'/*') ?: [] as $file) {
            if (is_file($file)) {
                $targetFilename = $agent->getTargetFilename($file);
                copy($file, $to.'/'.$targetFilename);
            }
        }
    }
}
