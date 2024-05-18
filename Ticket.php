<?php
require_once "Product.php";
class Ticket
{

    public array $products=[];

    public int $total;
    public function __construct( array $products)
    {

        $this->products = $products;
        $this->total = 0;
        foreach($products as $product)
        {
            $this->total += $product->total;
        }
    }
}