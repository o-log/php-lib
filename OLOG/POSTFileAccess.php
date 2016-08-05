<?php


namespace OLOG;

/**
 *
 * $file = new \OLOG\POSTFileAccess('file');
 *
 * $file->setValidators([
 *      new \OLOG\POSTFileValidatorMimeType($allowed_types),
 *      new \OLOG\POSTFileValidatorExtension($allowed_extensions),
 *      new \OLOG\POSTFileValidatorSize('1M'),
 * ]);
 *
 * if(!$file->validate()){
 *      echo $file->getErrorMessage();
 * }
 * Class POSTFileAccess
 * @package OLOG
 */
class POSTFileAccess
{
    protected static $units = array(
        'b' => 1,
        'k' => 1024,
        'm' => 1048576,
        'g' => 1073741824
    );

    protected static $errorCodeMessages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload'
    );

    protected $name;
    protected $type;
    protected $tmp_name;
    protected $upload_error_code;
    protected $size;
    protected $validators_arr = [];
    protected $error_message = '';

    public function __construct($key)
    {
        \OLOG\Assert::assert(array_key_exists($key, $_FILES));

        $this->name = $_FILES[$key]['name'];
        $this->type = $_FILES[$key]['type'];
        $this->tmp_name = $_FILES[$key]['tmp_name'];
        $this->upload_error_code = $_FILES[$key]['error'];
        $this->size = $_FILES[$key]['size'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTmpName()
    {
        return $this->tmp_name;
    }

    public function getUploadErrorCode()
    {
        return $this->upload_error_code;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getValidatorsArr()
    {
        return $this->validators_arr;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setTmpName($tmp_name)
    {
        $this->tmp_name = $tmp_name;
    }

    public function setUploadErrorCode($upload_error_code)
    {
        $this->upload_error_code = $upload_error_code;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setValidatorsArr($validators_arr)
    {
        $this->validators_arr = $validators_arr;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }

    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    public function getExtension()
    {
        return strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
    }

    /**
     * Add file validations
     * @param array [\OLOG\POSTFileValidatorInterface] $validators_arr
     */
    public function setValidators($validators_arr)
    {
        foreach ($validators_arr as $validator_obj) {
            \OLOG\Assert::assert($validator_obj instanceof POSTFileValidatorInterface);
        }

        $this->setValidatorsArr($validators_arr);
    }

    /**
     * Validate file
     * @return bool True if valid, false if invalid
     */
    public function validate()
    {
        if ($this->isOk() === false) {
            $this->setErrorMessage(self::$errorCodeMessages[$this->getUploadErrorCode()]);
            return false;
        }

        if ($this->isUploadedFile() === false) {
            $this->setErrorMessage('The uploaded file was not sent with a POST request');
            return false;
        }

        foreach ($this->getValidatorsArr() as $validator_obj) {
            /**
             * @var $validator_obj POSTFileValidatorInterface
             */
            if ($validator_obj->validate($this) === false) {
                $this->setErrorMessage($validator_obj->getErrorMessage());
                return false;
            }
        }

        return true;
    }

    public function isUploadedFile()
    {
        return is_uploaded_file($this->getTmpName());
    }


    public function isOk()
    {
        return ($this->getUploadErrorCode() === UPLOAD_ERR_OK);
    }

    /**
     * Convert human readable file size (e.g. "10K" or "3M") into bytes
     * @param  string $input
     * @return int
     */
    public static function humanReadableToBytes($input)
    {
        $number = (int)$input;
        $unit = strtolower(substr($input, -1));
        if (isset(self::$units[$unit])) {
            $number = $number * self::$units[$unit];
        }

        return $number;
    }
}