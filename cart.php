<?php

$sku = isset($_POST['sku']) ? $_POST['sku'] : "";
$qty = isset($_POST['how_many']) ? $_POST['how_many'] : 0;
$delete = isset($_GET['delete']) ? $_GET['delete'] : "";

include "db_connect.php";

if ($sku != "" && $qty > 0) {
    $qry = "INSERT INTO cart (sku, in_cart) VALUES ( '$sku', $qty )
        ON DUPLICATE KEY UPDATE in_cart = in_cart + $qty";

    $result = $db->query( $qry );
    // We should have some error checking here.

} elseif ($delete != "") {
    $qry = "DELETE FROM cart WHERE sku='$delete'";
    $result = $db->query( $qry );
    // We should have some error checking here.    
}

$qry = "SELECT
    inventory.sku
    , inventory.title
    , inventory.unit_price
    , cart.in_cart
    , inventory.unit_price * cart.in_cart as 'subtotal'
FROM
cart
LEFT JOIN inventory ON (
cart.sku = inventory.sku
)";

$result = $db->query( $qry );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <table class="table table-striped">
        <thead>
            <th>Title</th>
            <th>Unit Price</th>
            <th>In cart</th>
            <th>Subtotal</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
<?php
$total = 0;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $total = $total + $row['subtotal'];
    ?>
            <tr>
                <td><?=$row['title']?></td>
                <td><?=$row['unit_price']?></td>
                <td><?=$row['in_cart']?></td>
                <td><?=number_format($row['subtotal'], 2)?></td>
                <td><a href="?delete=<?=$row['sku']?>">Delete</a></td>
            </tr>
<?php
}
?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?=number_format($total, 2)?></td>
            </tr>
        </tfoot>
    </table>

    <a class="btn btn-primary" href="index.php">Continue Shopping</a>

</body>
</html>
