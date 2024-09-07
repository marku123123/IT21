<?php
include('./update_order_status.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backstage Cafe: Admin Operation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="navardesign/admindesignn.css">
    <link rel="stylesheet" href="navardesign/tabledesignn.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script defer src="active_link.js"></script>

</head>

<body>

    <!-- For Navar -->
    <?php
    include('navar/adminnavar.php')
    ?>
    <br><br><br><br><br>

    <div class="container">
        <div class="row">
            <h5 style="font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 30px; color: #9A4444; margin-left:10px; margin-bottom: 20px;">Cusotmers Order History <i class="bi bi-chevron-double-right"></i> Order Details</h5>
            <div class="d-flex justify-content-end">
                <a href="admincustomerorder.php">
                    <button type="button" class="btn" style="border-radius: 10px; width: 250px; font-size: 18px; background-color:#9A4444; color:white;">Back to Customer Orders</button>
                </a>
            </div>
        </div>
    </div><br>

    <?php
    require_once('dbconn.php');
    $utransac_id = isset($_GET['orderID']) ? $_GET['orderID'] : null;
    $stmt = $conn->prepare("SELECT *
            FROM customer
            JOIN ordersummary ON customer.customerID = ordersummary.customerID
            WHERE ordersummary.orderID = :orderID");
    $stmt->bindParam(':orderID', $utransac_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container" style="background-color: white; border-radius: 10px; box-shadow: 0px 0px 10px 0px #9A4444;">
        <?php
        $processed_ids = array();
        foreach ($results as $row) {
            $utransac_id = $row['orderID'];
            if (in_array($utransac_id, $processed_ids)) {
                continue;
            }
            $processed_ids[] = $utransac_id;
        ?>

            <div class="container">
                <div class="row">
                    <!-- Customer Details Column -->
                    <div class="col-12 col-md-8 col-lg-6 mb-6">
                        <div class="card" style="margin-top: 20px; margin-bottom: 10px; border: none;">
                            <div class="card-body">
                                <p class="card-title" style="font-family: Times New Roman, Times, serif; font-size: 22px;"></p><br>
                                <p class="card-title" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Customer: <strong><?php echo $row['name']; ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Username: <strong><?php echo $row['username']; ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Address: <strong><?php echo $row['address']; ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Mobile Number: <strong><?php echo $row['phonenumber']; ?></strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details Column -->
                    <div class="col-12 col-md-8 col-lg-6 mb-6">
                        <div class="card" style="margin-top: 20px; margin-bottom: 10px; border: none; background-color: inherit;">
                            <div class="card-body">
                                <span>
                                    <a class="receipt" href="./GENERATE_PDF.php?orderID=<?php echo $row['orderID']; ?>&customerName=<?php echo $row['name']; ?>&orderDate=<?php echo $row['pickup_at']; ?>" style="background-color: yellowgreen;" target="_blank">View</a>
                                    <button class="receipt" id="printButton_<?php echo $row['orderID']; ?>" onclick="printPDF(<?php echo $row['orderID']; ?>)" style="background-color: red;">Print</button>
                                </span>


                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Order ID: <strong><?php echo $row['orderID']; ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Order Date: <strong><?php echo date("F j, Y", strtotime($row['created_at'])) . ', ' . date("g:i A", strtotime($row['created_at'])); ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">PickUp Date: <strong><?php echo date("F j, Y", strtotime($row['pickup_at'])) . ', ' . date("g:i A", strtotime($row['pickup_at'])); ?></strong></p>
                                <p class="card-text" style="font-family: Times New Roman, Times, serif; font-size: 22px;">Order Total: ₱ <strong><?php echo number_format($row['totalprice'], 2); ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of row -->
            <?php } ?>
            </div><br><br>

            <div class="container">
                <section class="intro">
                    <div class="bg-image h-100">
                        <div class="mask d-flex align-items-center h-100">
                            <div class="container">
                                <div class="table-responsive">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px;">
                                                <table class="table table-striped mb-0">
                                                    <thead style="background-color: #9A4444;">
                                                        <tr>
                                                            <th class="text-center">Product ID</th>
                                                            <th class="text-center">Product Image</th>
                                                            <th class="text-center">Product Name</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once('dbconn.php');

                                                        $utransac_id = isset($_GET['orderID']) ? $_GET['orderID'] : null;
                                                        $stmt = $conn->prepare("SELECT *
                                                        FROM customer
                                                        JOIN ordersummary ON customer.customerID = ordersummary.customerID
                                                        JOIN orderdetails ON orderdetails.orderID = ordersummary.orderID
                                                        WHERE ordersummary.orderID = :orderID");
                                                        $stmt->bindParam(':orderID', $utransac_id);
                                                        $stmt->execute();
                                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        // Display order details in a table

                                                        foreach ($results as $row) {
                                                            echo '<tr>';
                                                            echo '<td class="text-center">' . $row['orderdetailID'] . '</td>';

                                                            // Check if 'menuprofile' key exists and is not empty before accessing it
                                                            if (isset($row['menuprofile']) && !empty($row['menuprofile'])) {
                                                                $menuprofile = base64_encode($row['menuprofile']);
                                                                $imageDataUri = 'data:image/jpeg;base64,' . $menuprofile;
                                                                echo '<td class="text-center"><img src="' . $imageDataUri . '" width="150" height="150"></td>';
                                                            } else {
                                                                echo '<td class="text-center">No image available</td>';
                                                            }

                                                            // Check if 'menuname' key exists before accessing it
                                                            $menuname = isset($row['menuname']) ? $row['menuname'] : '';

                                                            // Check if 'menuprice' key exists and is not empty before accessing it
                                                            if (isset($row['priceperItem']) && !empty($row['priceperItem'])) {
                                                                $menuprice = '₱' . $row['priceperItem']; // Add the peso sign (₱) to the price
                                                            } else {
                                                                $menuprice = 'N/A'; // Provide a default value if menuprice is not available
                                                            }

                                                            echo '<td class="text-center">' . $menuname . '</td>';
                                                            echo '<td class="text-center">' . $row['quantity'] . '</td>';
                                                            echo '<td class="text-center">' . $menuprice . '</td>';
                                                            echo '</tr>';
                                                        }

                                                        echo '</tbody>';
                                                        echo '</table>';

                                                        // Close the database connection
                                                        $conn = null;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
    </section>
    </div>
    </div><br><br><br>
</body>
<script>
    function printPDF(orderID) {
        // Create an anchor element to trigger the download
        var downloadLink = document.createElement('a');
        downloadLink.href = './GENERATE_PDF.php?orderID=' + orderID;
        downloadLink.target = '_blank';
        downloadLink.download = 'backstage.pdf'; // Use the specified filename

        // Simulate a click on the download link
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);

        // Update the order status via AJAX
        updateOrderStatus(orderID);
    }


    function updateOrderStatus(orderID) {
        // Send an AJAX request to update the order status
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_order_status.php', true); // Create a PHP script to update the order status
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response, e.g., show a success message
                console.log('Order status updated successfully.');
            }
        };
        xhr.send('orderID=' + orderID);
    }
</script>



</html>