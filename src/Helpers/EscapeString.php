<?php
namespace Se7entech\Contractnew\Helpers;

class EscapeString
{
   
    public static function escapeArray($con, $data): array
    {
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $data[$key] = self::escapeArray($con, $val);
            } else {
                $data[$key] = mysqli_real_escape_string($con, $val);
            }
        }

        return $data;
    }

    public static function escapeValue($con, $value){
        return mysqli_real_escape_string($con, $value);
    }
}