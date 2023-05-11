<?php

//get data passed from Voice Browser
$user = $_GET['user'];
$product = $_GET['product'];
$stock = $_GET['stock'];
$quantity = $_GET['quantity'];
$price = $_GET['price'];
$seller = $_GET['seller'];
$seller_phone = $_GET['seller_phone'];
$duration = $_GET['duration'];

$date = Date('Y-m-d'); //current date at server
$time = time(); //current time (in seconds format)
$id = $user . $time; //concatenation of contact ID (phone number) and time used as unique key

//connect to PostgreSQL database
$db = pg_connect("host=balarama.db.elephantsql.com port=5432 dbname=xryelmsw user=xryelmsw password=CIoXXDLI4L21xbThDFCHIh4zLbAdJ4-E");

if (!$db) {
    die('Could not connect: ' . pg_last_error());
}

//create mushroom table
$sql = "CREATE TABLE IF NOT EXISTS mushroom (seller_name TEXT NOT NULL, seller_phone TEXT NOT NULL, stock INTEGER NOT NULL, unit_price NUMERIC(10,2) NOT NULL)";
$result = pg_query($db, $sql);
if (!$result) {
    die('Error: ' . pg_last_error());
}

//create oil table
$sql = "CREATE TABLE IF NOT EXISTS oil (seller_name TEXT NOT NULL, seller_phone TEXT NOT NULL, stock INTEGER NOT NULL, unit_price NUMERIC(10,2) NOT NULL)";
$result = pg_query($db, $sql);
if (!$result) {
    die('Error: ' . pg_last_error());
}

//create orders table
$sql = "CREATE TABLE IF NOT EXISTS orders (buyer_phone TEXT NOT NULL, purchase_type TEXT NOT NULL, seller_name TEXT NOT NULL REFERENCES mushroom(seller_name) REFERENCES oil(seller_name), quantity INTEGER NOT NULL, unit_price NUMERIC(10,2) NOT NULL REFERENCES mushroom(unit_price) REFERENCES oil(unit_price), total_price NUMERIC(10,2) NOT NULL)";
$result = pg_query($db, $sql);
if (!$result) {
    die('Error: ' . pg_last_error());
}

//insert data into the specific table
if ($product == 'mushroom') {
    $sql = "INSERT INTO mushroom(seller_name, seller_phone, stock, unit_price) VALUES ('$seller', '$seller_phone', $stock, $price)";
    $result = pg_query($db, $sql);
    if (!$result) {
        die('Error: ' . pg_last_error());
    }
} elseif ($product == 'oil') {
    $sql = "INSERT INTO oil(seller_name, seller_phone, stock, unit_price) VALUES ('$seller', '$seller_phone', $stock, $price)";
    $result = pg_query($db, $sql);
    if (!$result) {
        die('Error: ' . pg_last_error());
    }
}

//check if there is enough stock before processing order
if ($product == 'mushroom') {
    $check_sql = "SELECT stock FROM mushroom WHERE seller_name = '$seller'";
} elseif ($product == 'oil') {
    $check_sql = "SELECT stock FROM oil WHERE seller_name = '$seller'";
}
$check_result = pg_query($db, $check_sql);
if (!$check_result) {
    die('Error: ' . pg_last_error());
}

$stock_row = pg_fetch_row($check_result);
if (!$stock_row) {
    die('Error: Seller not found');
}
$available_stock = $stock_row[0];
if ($available_stock < $quantity) {
    die('Error: Insufficient stock');
}
$new_stock = $available_stock - $quantity;

//update stock in the specific table
if ($product == 'mushroom') {
    $update_sql = "UPDATE mushroom SET stock = $new_stock WHERE seller_name = '$seller'";
} elseif ($product == 'oil') {
    $update_sql = "UPDATE oil SET stock = $new_stock WHERE seller_name = '$seller'";
}

$update_result = pg_query($db, $update_sql);
if (!$update_result) {
    die('Error: ' . pg_last_error());
}

$total_price = $quantity * $price;

$order_sql = "INSERT INTO orders (buyer_phone, purchase_type, seller_name, quantity, unit_price, total_price) VALUES ('$user', '$product', '$seller', $quantity, $price, $total_price)";

$result = pg_query($db, $order_sql);

if (!$result) {
    die('Error: ' . pg_last_error());
}

//close database connection
pg_close($db);

//provide response to user
$response = "Thank you for your purchase of $quantity kilograms of $product. Your total cost is $total_price"

    ?>