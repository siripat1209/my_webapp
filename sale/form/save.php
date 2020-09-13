<?php
require_once '../../db.php';
try {
    $productSTMT = $dbh->prepare('select * from product
        where id=:id');
    $productSTMT->execute(['id' => $_POST['product_id']]);
    $product = $productSTMT->fetchObject();
    $saleSTMT = $dbh->prepare('insert into sale set
        product_id=:product_id,
        amount=:amount,
        unit_price=:unit_price,
        summary_price=:summary_price,
        date=now()
    ');
    $saleSTMT->execute([
        'product_id' => $_POST['product_id'],
        'amount' => $_POST['amount'],
        'unit_price' => $product->price,
        'summary_price' => $product->price * $_POST['amount'],
    ]);
    $productUpdateSTMT = $dbh->prepare('
    update product set amount=:amount where id=:id
    ');
    $productUpdateSTMT->execute([
        'amount' => $product ->amount - $_POST['amount'],
        'id' => $_POST['product_id'],
    ]);
    header('location: /sale');
} catch (PDOException $e) {
    echo "ERROR: ".$e->getMessage();
}
?>