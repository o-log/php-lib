<?php


namespace OLOG;

/**
 * Класс представляет собой обёртку для работы с закачиваемыми на сервер файлами.
 *
 * Доступа к одному файлу с ключем(имя input поля типа file в html форме) 'upload_file':
 * $file_access_obj = new \OLOG\POSTFileAccess('upload_file');
 *
 * Во время инициализации объекта для этого файла проверяются:
 *      - не произошло ли ошибок при закачке файла
 *      - является ли этот файл загруженным
 * в случае ошибки выбрасывается исключение.
 *
 *
 * Над загруженным файлом можно произвести проверки:
 * $validators_arr = [
 *      new \OLOG\POSTFileValidatorMimeType(array('video/mp4', 'video/mpeg')), // валидация на разрешенные mime типы
 *      new \OLOG\POSTFileValidatorExtension(array('png','jpg','gif')), // валидация на расширение файла
 *      new \OLOG\POSTFileValidatorSize(20000), // валидация максимального размера файла
 * ];
 *
 * $error_message = '';
 * if(!$file_access_obj->validate($validators_arr, $error_message)) {
 *      echo $error_message;
 * }
 *
 * Доступ с свойствам загруженного файла:
 *  $file_access_obj->getOriginalFileName();
 *  $file_access_obj->getMimeType();
 *  $file_access_obj->getTempFilepath();
 *  $file_access_obj->getUploadErrorCode();
 *  $file_access_obj->getFileSize();
 *
 *
 * Если в post-форме ожидается массив файлов с ключем 'upload_files', можно получить массив объектов POSTFileAccess,
 * над которыми можно будет проводить все те же проверки и получать доступ к свойстам, что выше:
 *
 * $file_arr = \OLOG\POSTFileAccess::getPOSTFileObjArr('upload_files');
 * foreach ($file_arr as $file_access_obj) {
 *      $valid = $file->validate($validators, $error_message);
 *
 *      $file_access_obj->getOriginalFileName();
 *      $file_access_obj->getMimeType();
 *      $file_access_obj->getTempFilepath();
 *      $file_access_obj->getUploadErrorCode();
 *      $file_access_obj->getFileSize();
 * }
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
    public function __construct($key)
    {
        if ($key === null) {
            return;
        }

        \OLOG\Assert::assert(array_key_exists($key, $_FILES));
        \OLOG\Assert::assert(!is_array($_FILES[$key]['name']), 'multi file upload');
        $this->loadObjFromArray($_FILES[$key]);
    }

    /**
     * @param $key
     * @return array[POSTFileAccess]
     */
    public static function getPOSTFileObjArr($key)
    {
        \OLOG\Assert::assert(array_key_exists($key, $_FILES));

        $file_post_arr = $_FILES[$key];
        $post_file_access_arr = [];
        if (!is_array($file_post_arr['name'])) {
            $obj = new self($key);
            return [$obj];
        }

        $file_count = count($file_post_arr['name']);
        $file_keys = array_keys($file_post_arr);

        for ($i = 0; $i < $file_count; $i++) {
            $file_arr = array();
            foreach ($file_keys as $key) {
                $file_arr[$key] = $file_post_arr[$key][$i];
            }

            $obj = new self(null);
            $obj->loadObjFromArray($file_arr);

            $post_file_access_arr[] = $obj;
        }

        return $post_file_access_arr;
    }


    protected function loadObjFromArray($array)
    {
        \OLOG\Assert::assert(array_key_exists('name', $array));
        $this->setOriginalFileName($array['name']);

        \OLOG\Assert::assert(array_key_exists('size', $array));
        $this->setFileSize($array['size']);

        \OLOG\Assert::assert(array_key_exists('type', $array));
        $this->setMimeType($array['type']);

        \OLOG\Assert::assert(array_key_exists('tmp_name', $array));
        $this->setTempFilepath($array['tmp_name']);

        \OLOG\Assert::assert(array_key_exists('error', $array));
        $this->setUploadErrorCode($array['error']);

        \OLOG\Assert::assert($this->isOk(), self::$errorCodeMessages[$this->getUploadErrorCode()]);
        \OLOG\Assert::assert($this->isUploadedFile(), 'The uploaded file was not sent with a POST request');
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