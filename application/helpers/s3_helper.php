<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_s3_object($filePath) {
    // Load library S3
    $CI =& get_instance();
    $CI->load->library('s3_library');

    // Panggil fungsi getObject dari library S3
    return $CI->s3_library->getFilesObject($filePath, 10);
}
