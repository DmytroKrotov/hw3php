<?php
require_once "Product.php";
require_once "Ticket.php";

$Items=[];
$tickets=[];
function readProductsFromFile($filename): array
{

    if (!file_exists($filename)) {
        return [];
    }
    $jsonData = file_get_contents($filename);

    $data = json_decode($jsonData, true);

    $products = [];

    foreach ($data as $item) {
        $products[] = new Product($item['name'],$item['count'], $item['price']);
    }

    return $products;
}

function writeProductsToFile($filename, $products)
{

    $data = [];

    foreach ($products as $product) {

        $data[] = ['name' => $product->name,'count'=>$product->count, 'price' => $product->price];
    }
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    $res=file_put_contents($filename, $jsonData);

}

function readTicketsFromFile($filename): array
{

    if (!file_exists($filename)) {
        return [];
    }
    $jsonData = file_get_contents($filename);

    $data = json_decode($jsonData, true);

    $tickets = [];
    foreach ($data as $item) {

        $products=[];

        $productsData=$item['products'];

        foreach ($productsData as $productData)
        {

                $products[]=new Product($productData['name'],$productData['count'],$productData['price']);


        }
        $tickets[] = new Ticket($products);

    }

    return $tickets;
}

function writeTicketsToFile($filename, $tickets)
{
    $jsonData = json_encode($tickets, JSON_PRETTY_PRINT);

    $res=file_put_contents($filename, $jsonData);

}

$Items = readProductsFromFile("products.json");

$tickets = readTicketsFromFile("tickets.json");


if(isset($_GET["submit"]))
{
    $name=$_GET["name"];
    $count=$_GET["count"];
    $price=$_GET["price"];
    $product=new Product($name,$count,$price);
    $Items[]=$product;
    writeProductsToFile("products.json",$Items);

}


if(isset($_GET["ticket"]))
{
   $newTicket=new Ticket($Items);
   $tickets[]=$newTicket;
   writeTicketsToFile("tickets.json",$tickets);
   $Items=[];
   writeProductsToFile("products.json",$Items);

}

?>
   <form action='/hw3php/index.php' method='GET'>
        <label>Name</label>
        <input type='text' name='name'>
        <label>Count</label>
        <input type='text' name='count'>
        <label>Price</label>
        <input type='text' name='price'>
        <input type='submit' name='submit' value='Add Item'>
        <input type='submit' name='ticket' value='Buy'>
   </form>

<?php
echo "Products:<br>";
foreach($Items as $Item)
{
    echo("
        Name: $Item->name,
        Price: $Item->price,
        Count: $Item->count<br>
    ");
}
echo "<br>";
echo "<br>";
echo "TICKETS:<br><br>";
foreach($tickets as $Item)
{
    echo "Ticket----------------------<br><br>";
    $ticketProducts=$Item->products;
    foreach($ticketProducts as $product)
    {
        echo("
        Name: $product->name,
        Price: $product->price,
        Count: $product->count,
        Total: $product->total<br>
    ");

    }
    echo "Total price: $Item->total<br><br>";

}




