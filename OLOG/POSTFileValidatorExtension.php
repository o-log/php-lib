<?php


namespace OLOG;


class POSTFileValidatorExtension implements POSTFileValidatorInterface
{
    protected $error_message = '';
    protected $allowed_extensions_arr = [];

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
    public function getAllowedExtensionsArr()
    {
        return $this->allowed_extensions_arr;
    }

    /**
     * @param array $allowed_extensions_arr
     */
    public function setAllowedExtensionsArr($allowed_extensions_arr)
    {
        $this->allowed_extensions_arr = $allowed_extensions_arr;
    }

    /**
     * @param array $allowed_extensions_arr Allowed file extensions(without leading dot)
     * @example new \OLOG\POSTFileValidatorExtension(array('png','jpg','gif'))
     */
    public function __construct(array $allowed_extensions_arr)
    {
        array_filter($allowed_extensions_arr, function ($val) {
            return strtolower($val);
        });

        $this->setAllowedExtensionsArr($allowed_extensions_arr);
    }

    /**
     * @param POSTFileAccess $file_obj
     * @return bool
     */
    public function validate(POSTFileAccess $file_obj)
    {
        $file_extension = strtolower($file_obj->getExtension());
        $allowed_extentions_arr = $this->getAllowedExtensionsArr();

        if (!in_array($file_extension, $allowed_extentions_arr)) {
            $this->setErrorMessage('Invalid file extension. Must be one of: ' . implode(', ', $allowed_extentions_arr));
            return false;
        }

        return true;
    }
}