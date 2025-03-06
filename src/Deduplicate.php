<?php

namespace AkapCsvProcessor;

class Deduplicate
{
    public static function generateUniqueKey(array $row)
    {
        return md5(strtolower(
            $row['firstname'] . $row['middlename'] . $row['lastname'] . $row['extensionname'] . $row['birthdate']
        ));
    }
}