<?php

//get data passed from Voice Browser
$user = $_GET['user'];
$product = $_GET['product'];
$quantity = $_GET['quantity'];
$seller = $_GET['seller'];
$price = $_GET['price'];

$date = Date('Y-m-d'); //current date at server
$time = time(); //current time (in seconds format)
$id = $user . $time; //concatenation of contact ID (phone number) and time used as unique key

//connect to PostgreSQL database
$db = pg_connect("host=balarama.db.elephantsql.com port=5432 dbname=xryelmsw user=xryelmsw password=CIoXXDLI4L21xbThDFCHIh4zLbAdJ4-E");

if (!$db) {
    die('Could not connect: ' . pg_last_error());
}

//check if table exists
$table_name = $product == 'mushroom' ? 'mushroom' : 'oil';
$check_table_sql = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = '$table_name')";
$check_table_result = pg_query($db, $check_table_sql);
if (!$check_table_result) {
    die('Error: ' . pg_last_error());
}
$table_exists = pg_fetch_result($check_table_result, 0, 0);

if ($table_exists) {
    //check if there is enough stock before processing order
    $check_sql = "SELECT stock FROM $table_name WHERE seller_name = '$seller'";
    $check_result = pg_query($db, $check_sql);
    if (!$check_result) {
        die('Error: ' . pg_last_error());
    }
} else {
    die("Error: Table '$table_name' does not exist.");
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

$order_sql = "INSERT INTO orders (buyer_phone, purchase_type, seller_name, quantity, unit_price, total_price, date) VALUES ('$user', '$product', '$seller', $quantity, $price, $total_price, Now())";

$result = pg_query($db, $order_sql);

if (!$result) {
    die('Error: ' . pg_last_error());
}

//close database connection
pg_close($db);

//provide response to user
$response = "Thank you for your purchase of $quantity kilograms of $product. Your total cost is $total_price"

    ?>