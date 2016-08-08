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
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
    );

    protected $original_file_name;
    protected $mime_type;
    protected $tmp_file_path;
    protected $upload_error_code;
    protected $file_size;

    /**
     * @param $key
     * @return POSTFileAccess
     */
    public static function factory($key)
    {
        \OLOG\Assert::assert(array_key_exists($key, $_FILES));
        \OLOG\Assert::assert(!is_array($_FILES[$key]['name']), 'multi file upload');
        $obj = self::createObjFromArray($_FILES[$key]);
        return $obj;
    }

    /**
     * @param $key
     * @return array[POSTFileAccess]
     */
    public static function factoryArray($key)
    {
        \OLOG\Assert::assert(array_key_exists($key, $_FILES));

        $file_post_arr = $_FILES[$key];
        $post_file_access_arr = [];
        if (!is_array($file_post_arr['name'])) {
            return [self::createObjFromArray($file_post_arr)];
        }

        $file_count = count($file_post_arr['name']);
        $file_keys = array_keys($file_post_arr);

        for ($i = 0; $i < $file_count; $i++) {
            $file_arr = array();
            foreach ($file_keys as $key) {
                $file_arr[$key] = $file_post_arr[$key][$i];
            }
            $post_file_access_arr[] = self::createObjFromArray($file_arr);
        }

        return $post_file_access_arr;
    }

    protected static function createObjFromArray($array)
    {
        $obj = new self();
        \OLOG\Assert::assert(array_key_exists('name', $array));
        $obj->setOriginalFileName($array['name']);

        \OLOG\Assert::assert(array_key_exists('size', $array));
        $obj->setFileSize($array['size']);

        \OLOG\Assert::assert(array_key_exists('type', $array));
        $obj->setMimeType($array['type']);

        \OLOG\Assert::assert(array_key_exists('tmp_name', $array));
        $obj->setTempFilepath($array['tmp_name']);

        \OLOG\Assert::assert(array_key_exists('error', $array));
        $obj->setUploadErrorCode($array['error']);

        \OLOG\Assert::assert($obj->isOk(), self::$errorCodeMessages[$obj->getUploadErrorCode()]);
        \OLOG\Assert::assert($obj->isUploadedFile(), 'The uploaded file was not sent with a POST request');

        return $obj;
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

    public function validate($validators_arr, &$error_message = null)
    {
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