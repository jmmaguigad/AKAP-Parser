<?php

namespace AkapCsvProcessor;

class Cleanse
{
    public static function cleanRow(array $row)
    {
        // Remove any blank rows
        if (count(array_filter($row)) === 0) {
            return null;
        }

        // Just check for the first name if its legit or not, if not then skip the cleansing process
        $row['firstname'] = Helpers::cleanString($row['first name']);

        if ($row['firstname'] == 'FIRST NAME') {
            return null;
        }

        $row['middlename'] = Helpers::cleanString($row['middle name']);
        $row['lastname'] = Helpers::cleanString($row['last name']);
        $row['extensionname'] = Helpers::cleanString($row['extension name (jr,sr)']);
        $row['birth_date'] = Helpers::cleanBirthdate($row['birthdate (mm/dd/yyyy)']);
        $row['sex'] = Helpers::cleanString($row['sex']); //[0]
        $row['sex'] = strlen($row['sex']) > 1 ? $row['sex'][0] : $row['sex'];
        $row['province'] = Helpers::cleanString($row['province']);

        return $row;
    }
}