<?php


namespace OLOG;


interface POSTFileValidatorInterface
{
    public function validate(POSTFileAccess $file_obj, &$error_message);
}