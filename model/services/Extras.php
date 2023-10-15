<?php

class Extras
{
    public static function ValdiateMail(string $email)
    {
        return ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public static function UploadImage(array $params)
    {        
        $email = explode('@', $params[2]);
        $url = IMAGES . '/' . $params[0] . '-' . $params[1] . '-' . $email[0] . '-' . date("Y-m-d-H-i") . '.jpg';
        if(!is_dir(IMAGES))
        {
            mkdir(IMAGES, 0777, true);
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'], $url))
        {
            echo "uploaded\n";
            return true;
        }
        else
        {
            echo "upload aborted\n";
            return false;
        }
    }

    public static function CheckDate(string $date)
    {
        return DateTime::createFromFormat('Y-m-d', $date);
    }
}