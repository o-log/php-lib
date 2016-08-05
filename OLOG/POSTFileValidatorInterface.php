<?php


namespace OLOG;


interface POSTFileValidatorInterface
{
    public function validate(POSTFileAccess $file_obj);
    public function getErrorMessage();
    public function setErrorMessage($error_message);
}