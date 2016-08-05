<?php


namespace OLOG;


class POSTFileValidatorMimeType implements POSTFileValidatorInterface
{
    protected $error_message = '';
    protected $allowed_mime_types_arr = [];

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param string $error_message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
     * @return array
     */
    public function getAllowedMimeTypesArr()
    {
        return $this->allowed_mime_types_arr;
    }

    /**
     * @param array $allowed_mime_types_arr
     */
    public function setAllowedMimeTypesArr($allowed_mime_types_arr)
    {
        $this->allowed_mime_types_arr = $allowed_mime_types_arr;
    }

    /**
     * @param array $mime_types_arr Allowed mime file types
     * @example new \OLOG\POSTFileValidatorMimeType(array('video/mp4', 'video/mpeg'))
     */
    public function __construct(array $mime_types_arr)
    {
        $this->setAllowedMimeTypesArr($mime_types_arr);
    }

    /**
     * @param POSTFileAccess $file_obj
     * @return bool
     */
    public function validate(POSTFileAccess $file_obj)
    {
        $allowed_mime_types_arr = $this->getAllowedMimeTypesArr();
        if(!in_array($file_obj->getType(), $allowed_mime_types_arr)){
            $this->setErrorMessage('Invalid file mimetype. Must be one of: ' . implode(', ', $allowed_mime_types_arr));
            return false;
        }

        return true;
    }
}