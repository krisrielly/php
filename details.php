<?php

include "db_connect.php";

if (!isset($_GET['sku'])) {
    include "index.php";
    exit();
}

$sku = $_GET['sku'];

$qry = "SELECT * FROM inventory WHERE sku='$sku'";

$result = $db->query($qry);
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style>
    .price,.quantity {
        text-align: right;
    }
    .btn {
        background: linear-gradient(<?= rand(-360, 359)?>deg, #<?= dechex(rand(0, 16777215)) ?>, #<?= dechex(rand(0, 16777215)) ?>);
    }
    </style>
</head>
<body class="container">
    <div class="row">
        <div class="col">
            <h1><?=$row['title']?></h1>
            <p><?=$row['description']?></p>
        </div>
        <div class="col">
            <form action="cart.php" method="post">
                <input type="hidden" name="sku" value="<?=$row['sku']?>">
                Price: $<?=number_format($row['unit_price'], 2)?> each
                <br>
                <label for="how_many">How many?</label>
                <br>
                <input id="how_many" name="how_many" required="required">
                <br>
                <input type="submit" class="btn btn-primary" value="Add to cart">
            </form>
        </div>
    </div>

</body>
</html>