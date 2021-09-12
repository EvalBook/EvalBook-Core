<?php

/**
 * Provide simple file utilities.
 */
final class FileUtils {

    /**
     * Download a source from internet.
     * @param $url
     * @param $destination
     * @param $name
     * @return string|bool
     */
    public static function download($url, $destination, $name): bool|string
    {
        // $output = dirname($_SERVER['PHP_SELF']) . $destination . "/" . $name;
        $output = $destination . "/" . $name;

        // Removes file if already exists.
        if(file_exists($output)) {
            unlink($output);
        }
        $source = file_get_contents($url);
        $result = file_put_contents($output, $source, FILE_USE_INCLUDE_PATH | LOCK_EX);
        chmod($output, 0775);
        return $result ? $output : false;
    }

    /**
     * Well formatted print_r.
     * @param $data
     */
    public static function print_r2($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    /**
     * Remove all files from a folder.
     * @param $dir
     * @return bool
     */
    public static function unlinkRecursive($dir): bool
    {
        if(!$dh = @opendir($dir)) {
            return false;
        }

        while (false !== ($obj = readdir($dh))){
            // Pass if directory is a . or ..
            if($obj == '.' || $obj == '..') continue;

            if (!@unlink($dir . '/' . $obj)) {
                self::unlinkRecursive($dir . '/' . $obj);
            }
        }
        closedir($dh);
        return true;
    }
}