<?php

    echo "<h1> Bonjour !!! </h1>";

class Item
{
    private $api = 'https://localhost:8000';

    public function getAllItems(){
        return json_decode("{'24':13}", true);
    }
}

$itemA = new Item();

echo $itemA->getAllItems(); 

?>