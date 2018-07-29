<?php

include "db_connect.php";

$qry = "SELECT * FROM inventory";

// If we need to filter, put the WHERE clause code here.

// If the user specified a sort column, map that from the UI to the DB.
$itemsort = "";
if (isset($_GET['sortby'])) {

    $sortby = $_GET['sortby'];
    if (substr($sortby, 0, 4) == "item") {
        $orderby = " ORDER BY title";
        if (substr($sortby, -1) == "-") {
            $orderby = $orderby . " DESC";
            $itemsort = "";
        } else {
            $itemsort = "-";
        }
    } elseif ($sortby == "price") {
        $orderby = " ORDER BY unit_price";
    } elseif ($sortby == "qty") {
        $orderby = " ORDER BY in_stock";
    } else {
        $orderby = "";
    }

    $qry = $qry . ' ' . $orderby;
}

$result = $db->query( $qry );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style>
    table,th,td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .price,.quantity {
        text-align: right;
    }
    </style>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <th><a href="?sortby=item<?= $itemsort ?>">Item</a></th>
            <th><a href="?sortby=price">Unit Price</a></th>
            <th><a href="?sortby=qty">Quantity</a></th>
        </thead>
        <tbody>
<?php
while ( $row = $result->fetch( PDO::FETCH_ASSOC )) {
?>
            <tr>
                <td>
                    <a href="details.php?sku=<?= $row['sku'] ?>">
                    <?= $row['title'] ?>
                    </a>
                </td>
                <td class='price'>$<?= number_format($row['unit_price'], 2) ?></td>
                <td class='quantity'><?= $row['in_stock'] ?></td>
            </tr>
<?php
}
?>
        </tbody>
    </table>
</body>
</html>
