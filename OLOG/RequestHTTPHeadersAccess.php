<?php

namespace OLOG;


class RequestHTTPHeadersAccess
{
    static public function getRequiredRequestHTTPHeaderValue($header)
    {
        $value = '';

        $header_normalized = self::normalizeHeader($header);
        if (array_key_exists($header_normalized, $_SERVER)) {
            $value = $_SERVER[$header_normalized];
        }

        \OLOG\Assert::assert($value != '', 'Missing required request header field ' . $header_normalized);

        return $value;
    }

    static public function getOptionalRequestHTTPHeaderValue($header, $default = '')
    {
        $value = '';

        $header_normalized = self::normalizeHeader($header);
        if (array_key_exists($header_normalized, $_SERVER)) {
            $value = $_SERVER[$header_normalized];
        }

        if (!$value) {
            $value = $default;
        }

        return $value;
    }

    protected static function normalizeHeader($header)
    {
        return mb_strtoupper('HTTP_' . str_replace('-', '_', $header));
    }
}