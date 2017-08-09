<?php
class Mugen_utils
{
    public static function get_file_version( $url ) {
        $content_url = content_url();
        $filepath    = str_replace( $content_url, WP_CONTENT_DIR, $url );
        $filepath    = explode( '?', $filepath );
        $filepath    = array_shift( $filepath );
        // Ensure the file actually exists.
        if ( ! file_exists( $filepath ) ) {
            return;
        }
        // Attempt to read the file timestamp.
        try {
            $timestamp = filemtime( $filepath );
        } catch ( \Exception $e ) {
            return;
        }
        return $timestamp ? (string) $timestamp : null;
    }
}
