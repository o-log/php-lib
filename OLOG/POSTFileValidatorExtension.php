<?php


namespace OLOG;


class POSTFileValidatorExtension implements POSTFileValidatorInterface
{
    protected $allowed_extensions_arr = [];

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
    public function validate(POSTFileAccess $file_obj, &$error_message)
    {
        $file_extension = strtolower($file_obj->getExtension());
        $allowed_extentions_arr = $this->getAllowedExtensionsArr();

        if (!in_array($file_extension, $allowed_extentions_arr)) {
            $error_message = 'Invalid file extension. Must be one of: ' . implode(', ', $allowed_extentions_arr);
            return false;
        }

        return true;
    }
}