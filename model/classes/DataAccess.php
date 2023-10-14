<?php

class DataAccess
{
    public static function ReadFile(string $element)
    {
        if(!in_array($element, elements))
        {
            return false;
        }
        else
        {
            $path = APP_ROOT . "/data/{$element}.json";
            $file = fopen($path, "r");
            $content = fread($file, filesize($path));
            fclose($file);
            return json_decode($content, true);
        }
    }

    public static function WriteFile(string $element, $content)
    {
        if(!in_array($element, elements))
        {
            return false;
        }
        else
        {
            $path = APP_ROOT . "/data/{$element}.json";
            $file = fopen($path, "w");
            fwrite($file, json_encode($content, JSON_PRETTY_PRINT));
            fclose($file);
            return true;
        }
    }

    public static function SearchForItem(string $itemType, string $attribute, string $value)
    {
        $matches = [];
        $items = DataAccess::ReadFile($itemType);
        
        if($items !== false)
        {
            foreach($items as $item)
            {                
                if(is_numeric($value) && $value <= $item['attributes'][$attribute])
                {
                    array_push($matches, $item['attributes']['id']);
                }
                elseif ($item['attributes'][$attribute] == $value)
                {
                    array_push($matches, $item['attributes']['id']);
                }
            }
            if(count($matches) > 0)
            {
                //echo "{$attribute} = {$value}\ntrue\n";
                //echo "true\n";
                return $matches;
            }
            else
            {
                //echo "{$attribute} = {$value}\n";
                //echo "false\n";
                return false;
            }
        }
        return false;
    }
}