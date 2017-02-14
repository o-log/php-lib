<?php


namespace OLOG;


class POSTFileValidatorMimeType implements POSTFileValidatorInterface
{
    protected $allowed_mime_types_arr = [];

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
    public function validate(POSTFileAccess $file_obj, &$error_message)
    {
        $allowed_mime_types_arr = $this->getAllowedMimeTypesArr();
        $mime_type = $file_obj->getMimeType();
        if (!in_array($mime_type, $allowed_mime_types_arr)) {
            $error_message = 'Invalid file mimetype: ' . $mime_type . '. Must be one of: ' . implode(', ', $allowed_mime_types_arr);
            return false;
        }

        return true;
    }
}