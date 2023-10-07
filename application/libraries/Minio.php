<?php
// require_once('vendor/aws-autoloader.php');
// require_once('vendor/autoload.php');
#date_default_timezone_set('America/Los_Angeles');
/**
 * Amazon S3 Upload PHP class
 * @version 0.1
 */
class Minio
{

	function __construct()
	{
		$this->CI = &get_instance();
		$this->bucket = $this->CI->config->item('bucket_name');
		$this->s3 = new Aws\S3\S3Client([
			'version' => 'latest',
			'region' => 'ap-southeast-3',
			'endpoint' => $this->CI->config->item('s3_url'),
			'use_path_style_endpoint' => true,
			'http'    => ['verify' => false],
			'https'    => ['verify' => false],
			'credentials' => [
				'key' => $this->CI->config->item('access_key'),
				'secret' => $this->CI->config->item('secret_key'),
				'token' => '',
			],
		]);
		$this->s3get = new Aws\S3\S3Client([
			'version' => 'latest',
			'region' => 'ap-southeast-3',
			'endpoint' => $this->CI->config->item('s3_url_get'),
			'use_path_style_endpoint' => true,
			'http'    => ['verify' => false],
			'https'    => ['verify' => false],
			'credentials' => [
				'key' => $this->CI->config->item('access_key'),
				'secret' => $this->CI->config->item('secret_key'),
				'token' => '',
			],
		]);
	}

	function uploadFilesObject($filepathsource, $filepathdest, $foldername, $expire_time)
	{
		$folder = strtolower($foldername);
		$objectIsExist = $this->s3->doesObjectExist($this->bucket, $folder);
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepathsource);

		$statusCode = "";
		$responseput = array();
		if (!$objectIsExist) {
			$response = $this->createFolder($this->bucket, $folder);
			$statusCode = $response['@metadata']['statusCode'];
		} else {
			$statusCode = "201";
		}

		//echo $statusCode;

		if ($statusCode == 200 || $statusCode == '201') {
			$responseputs = $this->s3->putObject([
				'Bucket' 	  => $this->bucket,
				'Key' 		  => $filepathdest,
				'SourceFile'  => $filepathsource,
				'Body' 		  => '',
				'ContentType' => $mime_type,
				'ACL'    	  => 'public-read',
			]);

			$cmd = $this->s3->getCommand('GetObject', [
				'Bucket' => $this->bucket,
				'Key' => $filepathdest
			]);

			$request = $this->s3->createPresignedRequest($cmd, '+' . $expire_time . ' minutes');

			$responseput = array('url_no_encode' => $responseputs['ObjectURL'], 'url_encoded' => (string)$request->getUri());
		}

		return $responseput;
	}

	function getFilesObject($filepathdest, $expire_time)
	{
		$responseput = array();

		if (($filepathdest != null || $filepathdest != '') && ($expire_time != null || $expire_time != '')) {
			$filepathdest = (substr($filepathdest, 0, 1) === '/' ? substr($filepathdest, 1, strlen($filepathdest) - 1) : $filepathdest);
			$cmd = $this->s3get->getCommand('GetObject', [
				'Bucket' => $this->bucket,
				'Key' => $filepathdest
			]);
			$request = $this->s3get->createPresignedRequest($cmd, '+' . $expire_time . ' minutes');
			$responseput = array('url_encoded' => (string)$request->getUri());
		}
		return $responseput;
	}

	function checkExistingObject($filepathdest){
        $objectIsExist = $this->s3->doesObjectExist($this->bucket, $filepathdest);

        return $objectIsExist;
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

	function deleteFileObject($filepathdest){
        $resultdel = $this->s3->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key' => $filepathdest
        ));

        return $resultdel;
    }

    function download($filepathdest, $expire_time) {
        $object = $this->s3get->getObject([
            'Bucket' => $this->bucket,
            'Key' => $filepathdest            
        ]);

        
        $tmp = explode('/', $filepathdest);
        $filename = end($tmp);

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $object["ContentType"]);
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        echo $object["Body"];
    }

	public function pathfolder($year = null, $month = null)
    {
        $pathfolder = $result['config_value'];
        $thn = $year != null ? $year : date('Y');
        $pathfolder .= '/' . $thn;
        if (!file_exists($pathfolder)) {
            mkdir($pathfolder, 0777, true);
        }
        $month = $month != null ? $month : date('m');
        $pathfolder .= '/' . $month;
        if (!file_exists($pathfolder)) {
            mkdir($pathfolder, 0777, true);
        }
        return $pathfolder . '/';
    }
}
