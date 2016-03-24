<html>
<head>
    <meta charset="UTF-8">

    <script src="sorttable.js"></script>
    <title>Cycle Part Price Checker</title>
    <link rel="stylesheet" type="text/css" href="foundation-6/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script>
        function getTable() {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var myNode = document.getElementById("resultstbody");
                    while (myNode.firstChild) {
                        myNode.removeChild(myNode.firstChild);
                    }
                    document.getElementById("resultstbody").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET","/tableGen.php?q="+document.getElementById("searchBox").value,true);
            xmlhttp.send();
        }
    </script>

</head>
<body>
<header>
    <div class="headerContainer">
        <span class="headerTitle">
            <a href="index.html">Cycle Part Price Checker</a>
        </span>
    </div>
</header>
<div class="maincontentwrapper">
    <div class="mainContent">
        <form action="" method="get">
            <div class="row">
                <div class="large-12 columns" style="padding-top:10px;">
                    <input id="searchBox" type="text" name="q" placeholder="Search..." onkeyup="getTable()">
                </div>
            </div>
        </form>
        <table class="prodTable sortable" role="grid">
            <thead>
                <th>Retailer</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Price (GBP)</th>
            </thead>
            <tbody id="resultstbody">
            <?php
            /**
             * Created by PhpStorm.
             * User: Adam
             * Date: 15/03/2016
             * Time: 17:12
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
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
