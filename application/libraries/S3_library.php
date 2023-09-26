<?php 
require_once('vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3_library
{
	protected $CI;
    protected $minio;

    public function __construct() {
		$this->CI = &get_instance();
	
		// Ambil konfigurasi dari database, termasuk URL endpoint dan pengaturan SSL
		$this->CI->load->database();
		$this->minio_endpoint     = $this->CI->db->where('id', 40)->get('pengaturan')->row()->val;
		$this->minio_access_key   = $this->CI->db->where('id', 41)->get('pengaturan')->row()->val;
        $this->minio_secret_key   = $this->CI->db->where('id', 42)->get('pengaturan')->row()->val;
		$this->minio_use_ssl      = $this->CI->db->where('id', 43)->get('pengaturan')->row()->val;
		$this->minio_port         = $this->CI->db->where('id', 44)->get('pengaturan')->row()->val;
		$this->minio_bucket       = $this->CI->db->where('id', 45)->get('pengaturan')->row()->val;
		$this->minio_folder       = $this->CI->db->where('id', 46)->get('pengaturan')->row()->val;

    	// Inisialisasi koneksi S3 dengan endpoint dari database
		$this->s3 = new Aws\S3\S3Client([
			'version' => 'latest',
			'region' => 'ap-southeast-3',
			'endpoint' => $this->minio_endpoint,
			'use_path_style_endpoint' => true,
			'http'    => ['verify' => false],
			'https'    => ['verify' => false],
			'credentials' => [
				'key' => $this->minio_access_key,
				'secret' => $this->minio_secret_key,
				'token' => '',
			],
		]);
    }

	function uploadFilesObject($filepathsource, $filepathdest, $foldername, $expire_time)
	{
		$folder = strtolower($foldername);
		$objectIsExist = $this->s3->doesObjectExist($this->minio_bucket, $folder);
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepathsource);

		$statusCode = "";
		$responseput = array();
		if (!$objectIsExist) {
			$response = $this->createFolder($this->minio_bucket, $folder);
			$statusCode = $response['@metadata']['statusCode'];
		} else {
			$statusCode = "201";
		}

		//echo $statusCode;

		if ($statusCode == 200 || $statusCode == '201') {
			$responseputs = $this->s3->putObject([
				'Bucket' 	  => $this->minio_bucket,
				'Key' 		  => $filepathdest,
				'SourceFile'  => $filepathsource,
				'Body' 		  => '',
				'ContentType' => $mime_type,
				'ACL'    	  => 'public-read',
			]);

			$cmd = $this->s3->getCommand('GetObject', [
				'Bucket' => $this->minio_bucket,
				'Key' => $filepathdest
			]);

			$request = $this->s3->createPresignedRequest($cmd, '+' . $expire_time . ' minutes');

			$responseput = array('url_no_encode' => $responseputs['ObjectURL'], 'url_encoded' => (string)$request->getUri());
		}

		return $responseput;
	}

	function createFolder($bucket, $folder)
	{
		$resultput = $this->s3->putObject(array(
			'Bucket' => $bucket,
			'Key'    => $folder, //"abc/",
			'Body'   => "",
			'ACL'    => 'public-read'
		));

		return $resultput;
	}
	
	function getFilesObject($filepathdest, $expire_time)
	{
		$responseput = array();

		if (($filepathdest != null || $filepathdest != '') && ($expire_time != null || $expire_time != '')) {
			$filepathdest = (substr($filepathdest, 0, 1) === '/' ? substr($filepathdest, 1, strlen($filepathdest) - 1) : $filepathdest);
			$cmd = $this->s3->getCommand('GetObject', [
				'Bucket' => $this->minio_bucket,
				'Key' => $filepathdest
			]);
			$request = $this->s3->createPresignedRequest($cmd, '+' . $expire_time . ' minutes');
			$responseput = (string)$request->getUri();
		}
		return $responseput;
	}

}
