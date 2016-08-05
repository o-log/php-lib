<?php


namespace OLOG;


class POSTFileValidatorSize implements POSTFileValidatorInterface
{
    protected $error_message = '';
    protected $max_file_size_bytes;

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
     * @return int
     */
    public function getMaxFileSizeBytes()
    {
        return $this->max_file_size_bytes;
    }

    /**
     * @param int $max_file_size_bytes
     */
    public function setMaxFileSizeBytes($max_file_size_bytes)
    {
        $this->max_file_size_bytes = $max_file_size_bytes;
    }

    /**
     * @param int|string $max_file_size Max file size as an integer (in bytes) or as a human-readable string (e.g. "5M").
     * @example new \OLOG\POSTFileValidatorSize('10G')
     * @example new \OLOG\POSTFileValidatorSize('5M')
     * @example new \OLOG\POSTFileValidatorSize(20000)
     */
    public function __construct($max_file_size)
    {
        if (is_string($max_file_size)) {
            $max_file_size = POSTFileAccess::humanReadableToBytes($max_file_size);
        }
        $this->setMaxFileSizeBytes($max_file_size);
    }

    /**
     * @param POSTFileAccess $file_obj
     * @return bool
     */
    public function validate(POSTFileAccess $file_obj)
    {
        $fileSize = $file_obj->getSize();

        if ($fileSize > $this->getMaxFileSizeBytes()) {
            $this->setErrorMessage('File size is too large');
            return false;
        }

        return true;
    }


}