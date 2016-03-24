<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24/03/2016
 * Time: 13:32
 */

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $search = test_input($_GET['q']);
    $search = "%".$search."%";

    require("mysqlinfo.php");

    $conn = new PDO('mysql:host=localhost;dbname=cyclepartpricechecker_db;charset=utf8', $sqlusername, $sqlpassword, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $conn->prepare("SELECT * FROM wiggleprods WHERE prodname LIKE :searchvalue");
    $stmt->bindValue(":searchvalue", $search);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".'<a href='."http://www.wiggle.co.uk/".">"."Wiggle"."</a>"."</td>";
            echo "<td>".'<a href='.$row['produrl'].">".$row['prodname']."</a>"."</td>";
            echo "<td>".$row['brand']."</td>";
            echo "<td>".$row['prodpricegbp']."</td>";
            echo "</tr>";
        }
    }
    $stmt = $conn->prepare("SELECT * FROM bikediscountprods WHERE prodname LIKE :searchvalue");
    $stmt->bindValue(":searchvalue", $search);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".'<a href='."http://www.bike-discount.de/".">".'BikeDiscount.de'."</a>"."</td>";
            echo "<td>".'<a href='.$row['produrl'].">".$row['prodname']."</a>"."</td>";
            echo "<td>".$row['brand']."</td>";
            echo "<td>".$row['prodpricegbp']."</td>";
            echo "</tr>";
        }
    }
    $stmt = $conn->prepare("SELECT * FROM crcprods WHERE prodname LIKE :searchvalue");
    $stmt->bindValue(":searchvalue", $search);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".'<a href='."http://www.chainreactioncycles.com/".">".'Chain Reaction Cycles'."</a>"."</td>";
            echo "<td>".'<a href='.$row['produrl'].">".$row['prodname']."</a>"."</td>";
            echo "<td>".$row['brand']."</td>";
            echo "<td>".$row['prodpricegbp']."</td>";
            echo "</tr>";
        }
    }
}