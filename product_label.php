<?php
// Datenbankverbindung herstellen
require_once "inc_all.php";

// Produktinformationen abrufen
$product_id = intval($_GET['product_id']);
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = mysqli_query($mysqli, $sql);
$product = mysqli_fetch_assoc($result);

$product_name = htmlspecialchars($product['product_name']);
$product_code = htmlspecialchars($product['product_code']);
$product_price = number_format($product['product_price'], 2, '.', '');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Labeldruck</title>
    <style>
    @media print {
        @page {
            size: 100mm 50mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
    }
    .label {
        width: 62mm;
        height: 29mm;
        margin: 1mm;
        padding: 0mm;
        font-size: 12px;
        border: solid black 0.1mm;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }
    .barcode {
        display: block;
        margin: 0 auto;
        align-self: center;
        width: 40mm; /* Breite des Barcodes */
        height: 15mm; /* Höhe des Barcodes */
    }
    .qrcode {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 20mm;
    height: 20mm;
}

    </style>
</head>
<body>
    <div class="label">
        <div>
            <strong>Name:</strong> <?php echo $product_name; ?><br>
            <strong>Price:</strong> <?php echo $product_price; ?> €
        </div>
        <svg id="barcode" class="barcode"></svg>
        <canvas id="qrcode" class="qrcode"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
    <script>
        // Barcode generieren
        JsBarcode("#barcode", "<?php echo $product_code; ?>", {
            format: "CODE128",
            displayValue: true,
            fontSize: 18
        });

        // QR-Code generieren
        QRCode.toCanvas(document.getElementById("qrcode"), "https://itflow:8890/products.php?q=<?php echo $product_code; ?>", {
            width: 40, // Größe des QR-Codes in Pixeln
            margin: 1
        }, function (error) {
            if (error) console.error(error);
            console.log('QR code generated!');
        });

        // Automatisch drucken
        //window.onload = function() {
        //    window.print();
        //};
    </script>
</body>
</html>
