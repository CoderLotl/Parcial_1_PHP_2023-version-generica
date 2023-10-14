<?php

class ItemManager
{
    public static function SaveItem($item, string $itemType)
    {
        $id = 0;
        $items = DataAccess::ReadFile($itemType);
        
        if(count($items) > 0)
        {
            foreach($items as $anItem)
            {
                $id = $anItem['attributes']['id'];
            }
        }
        
        $item->attributes['id'] = $id+1;
        array_push($items, $item);
        if(DataAccess::WriteFile($itemType, $items))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function SavePizza(Pizza $item, string $itemType)
    {
        $id = 0;
        $found = false;
        $items = DataAccess::ReadFile($itemType);
        
        if(count($items) > 0)
        {
            foreach($items as &$anItem)
            {
                $id = $anItem['attributes']['id'];
                if($anItem['attributes']['sabor'] == $item->attributes['sabor'] && $anItem['attributes']['tipo'] == $item->attributes['tipo'])
                {                    
                    $anItem['attributes']['precio'] = $item->attributes['precio'];
                    $anItem['attributes']['cantidad'] += $item->attributes['cantidad'];
                    $found = true;
                    echo "Stock actualizado.\n";
                    break;
                }                
            }
        }        
        
        $item->attributes['id'] = $id+1;
        if($found == false)
        {
            array_push($items, $item);
        }
        if(DataAccess::WriteFile($itemType, $items))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function SearchMultipleParams(Array $params)
    {
        $matches = [];        
        
        foreach($params as $param => $value)
        {            
            $matchResult = DataAccess::SearchForItem($_REQUEST['search'], $param, $value);
            if($matchResult === false)
            {
                return false;
            }
            array_push($matches, $matchResult);
        }        
        
        foreach ($matches as $param => $values)
        {
            foreach ($values as $value)
            {
                $foundInAllArrays = true;
                foreach ($matches as $paramBis => $valuesBis)
                {
                    if ($param !== $paramBis && !in_array($value, $valuesBis))
                    {
                        $foundInAllArrays = false;
                        break;
                    }
                }
                if ($foundInAllArrays) {
                    return true;
                }
            }
        }

        return false;
    }
}