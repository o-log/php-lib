<?php


namespace OLOG;


class POSTFileValidatorSize implements POSTFileValidatorInterface
{
    protected $max_file_size_bytes;

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
     * @param int|string $max_file_size_bytes Max file size as an integer (in bytes).
     * @example new \OLOG\POSTFileValidatorSize(20000)
     */
    public function __construct($max_file_size_bytes)
    {
        $this->setMaxFileSizeBytes($max_file_size_bytes);
    }

    /**
     * @param POSTFileAccess $file_obj
     * @return bool
     */
    public function validate(POSTFileAccess $file_obj, &$error_message)
    {
        $fileSize = $file_obj->getFileSize();

        if ($fileSize > $this->getMaxFileSizeBytes()) {
            $error_message = 'File size is too large';
            return false;
        }

        return true;
    }
}