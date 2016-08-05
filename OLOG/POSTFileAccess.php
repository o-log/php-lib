<?php


namespace OLOG;

/**
 *
 * $file_access_obj = new \OLOG\POSTFileAccess('file');
 *
 * $validators_arr = [
 *      new \OLOG\POSTFileValidatorMimeType(array('video/mp4', 'video/mpeg')),
 *      new \OLOG\POSTFileValidatorExtension(array('png','jpg','gif')),
 *      new \OLOG\POSTFileValidatorSize(20000),
 * ];
 *
 * $error_message = '';
 * if(!$file_access_obj->validate($validators_arr, $error_message)) {
 *      echo $error_message;
 *      return;
 * }
 *
 * // Access data about the file that has been uploaded
 * $file_access_obj->getOriginalFileName();
 * $file_access_obj->getMimeType();
 * $file_access_obj->getTempFilepath();
 * $file_access_obj->getUploadErrorCode();
 * $file_access_obj->getFileSize();
 *
 */
class POSTFileAccess
{
    protected static $errorCodeMessages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload'
    );

    protected $original_file_name;
    protected $mime_type;
    protected $tmp_file_path;
    protected $upload_error_code;
    protected $file_size;

    public function __construct($key)
    {
        \OLOG\Assert::assert(array_key_exists($key, $_FILES));

        $this->setFileSize($_FILES[$key]['size']);
        $this->setOriginalFileName($_FILES[$key]['name']);
        $this->setMimeType($_FILES[$key]['type']);
        $this->setTempFilepath($_FILES[$key]['tmp_name']);
        $this->setUploadErrorCode($_FILES[$key]['error']);
    }

    public function getOriginalFileName()
    {
        return $this->original_file_name;
    }

    public function getMimeType()
    {
        return $this->mime_type;
    }

    public function getTempFilepath()
    {
        return $this->tmp_file_path;
    }

    public function getUploadErrorCode()
    {
        return $this->upload_error_code;
    }

    public function getFileSize()
    {
        return $this->file_size;
    }

    public function setOriginalFileName($original_file_name)
    {
        $this->original_file_name = $original_file_name;
    }

    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;
    }

    public function setTempFilepath($tmp_file_path)
    {
        $this->tmp_file_path = $tmp_file_path;
    }

    public function setUploadErrorCode($upload_error_code)
    {
        $this->upload_error_code = $upload_error_code;
    }

    public function setFileSize($file_size)
    {
        $this->file_size = $file_size;
    }

    public function getExtension()
    {
        return strtolower(pathinfo($this->original_file_name, PATHINFO_EXTENSION));
    }

    public function validate($validators_arr, &$error_message)
    {
        if ($this->isOk() == false) {
            $error_message = self::$errorCodeMessages[$this->getUploadErrorCode()];
            return false;
        }

        if ($this->isUploadedFile() === false) {
            $error_message = 'The uploaded file was not sent with a POST request';
            return false;
        }

        foreach ($validators_arr as $validator_obj) {
            /**
             * @var $validator_obj POSTFileValidatorInterface
             */

            \OLOG\Assert::assert($validator_obj instanceof POSTFileValidatorInterface);
            $validator_error_message = '';
            if ($validator_obj->validate($this, $validator_error_message) === false) {
                $error_message = $validator_error_message;
                return false;
            }
        }

        return true;
    }

    public function isUploadedFile()
    {
        return is_uploaded_file($this->getTempFilepath());
    }

    public function isOk()
    {
        return ($this->getUploadErrorCode() === UPLOAD_ERR_OK);
    }
}