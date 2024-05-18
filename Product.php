<?php

class Product
{
    public string $name;
    public string $price;
    public string $count;

    public int $total;
    public function __construct($name,$count,$price)
    {
        $this->name = $name;
        $this->price=$price;
        $this->count=$count;
        $this->total=(int)$price*(int)$count;
    }


}