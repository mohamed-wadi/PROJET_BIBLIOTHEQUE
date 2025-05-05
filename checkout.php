<?php include ('connexion/test_connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header/HeadHom.html'); ?>
    <script src="https://www.paypal.com/sdk/js?client-id=AStyBNb6k10rla9PyxX_RL5sKZ0kjCEaNNS99BINt384BRvZ5KFPbWchsCDnQg7CMxxgM9JSIX4cSYNm"></script>
</head>

<body>
    <div class="page-wrapper">
        <?php include("header/header_client.php"); ?>

        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">Checkout<span>Shop</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="checkout">
                    <div class="container">
                        <h1 class="checkout-title">Billing Details</h1><!-- End .checkout-title -->
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6">

                                    <?php
                                    // Check if the user is logged in
                                    if (isset($_SESSION['id_client'])) {
                                        $userId = $_SESSION['id_client'];

                                        // Query to fetch user details based on the user ID
                                        $sql = "SELECT nom_client, prenom_client, country, genre, phone, email FROM client WHERE id_client = ?";

                                        // Prepare the statement
                                        $stmt = $connexion->prepare($sql);

                                        if ($stmt) {
                                            // Bind parameters and execute the statement
                                            $stmt->bind_param("i", $userId);
                                            $stmt->execute();

                                            // Bind result variables
                                            $stmt->bind_result($nom_client, $prenom_client, $country, $genre, $phone, $Email);

                                            // Fetch user details
                                            $stmt->fetch();

                                            // Output the user details in the form
                                    ?>
                                            <div class="row">
                                                <label>First Name *</label>
                                                <input type="text" class="form-control" required value="<?php echo $prenom_client; ?>">

                                                <label>Last Name *</label>
                                                <input type="text" class="form-control" required value="<?php echo $nom_client; ?>">

                                                <label>County *</label>
                                                <input type="text" class="form-control" required value="<?php echo $country; ?>">

                                                <label>Sex *</label>
                                                <input type="text" class="form-control" required value="<?php echo $genre; ?>">

                                                <label>Phone *</label>
                                                <input type="tel" class="form-control" required value="<?php echo $phone; ?>">

                                                <label>Email *</label>
                                                <input type="text" class="form-control" required value="<?php echo $Email; ?>">
                                            </div><!-- End .row -->
                                    <?php

                                            // Close the statement after fetching the result
                                            $stmt->close();
                                        } else {
                                            // Handle the case where the statement preparation failed
                                            echo "Error preparing SQL statement.";
                                        }
                                    }
                                    ?>
                                </div><!-- End .col-lg-9 -->
                                <aside class="col-lg-6">
                                    <div class="summary">
                                        <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                        <?php
                                        // Assuming the user is authenticated and their ID is stored in a session variable

                                        // Check if the user is logged in
                                        if (isset($_SESSION['id_client'])) {
                                            // Get the user ID from the session
                                            $userId = $_SESSION['id_client'];

                                            // Fetch user details for billing information
                                            $billingInfoSql = "SELECT nom_client, prenom_client, country, genre, phone, Email FROM client WHERE id_client = ?";
                                            $billingStmt = $connexion->prepare($billingInfoSql);
                                            $billingStmt->bind_param("i", $userId);
                                            $billingStmt->execute();
                                            $billingStmt->bind_result($nom_client, $prenom_client, $country, $genre, $phone, $Email);
                                            $billingStmt->fetch();
                                            $billingStmt->close(); // Close the billing statement here

                                            // Fetch cart items
                                            $cartSql = "SELECT L.titre_livre, S.price 
                                                        FROM shoppingcart S
                                                        INNER JOIN livre L ON S.ISBN = L.ISBN
                                                        WHERE S.id_client = ?";
                                            $cartStmt = $connexion->prepare($cartSql);
                                            $cartStmt->bind_param("i", $userId);
                                            $cartStmt->execute();
                                            $cartResult = $cartStmt->get_result();

                                            // Check if cart items are found
                                            if ($cartResult->num_rows > 0) {
                                                $cartItems = $cartResult->fetch_all(MYSQLI_ASSOC);
                                        ?>
                                                <div class="row">

                                                    <table class="table table-summary">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($cartItems as $cartItem) { ?>
                                                                <tr>
                                                                    <td><a href="#">
                                                                            <?php echo $cartItem['titre_livre']; ?>
                                                                        </a></td>
                                                                    <td>$
                                                                        <?php echo number_format($cartItem['price'], 2); ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>

                                                            <tr class="summary-total">
                                                                <td>Total:</td>
                                                                <td>
                                                                    <?php
                                                                    // Calculate the total price
                                                                    $totalPrice = array_sum(array_column($cartItems, 'price'));
                                                                    echo '$' . number_format($totalPrice, 2);
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- End .row -->
                                        <?php
                                            } else {
                                                echo "No items in the cart."; // Handle this case as needed
                                            }

                                            $cartStmt->close();
                                            $connexion->close();
                                        } else {
                                            echo "User not logged in."; // Handle this case as needed
                                        }
                                        ?>
                                        <div class="accordion-summary" id="accordion-payment">
                                            <div id="paypal-button-container"></div>
                                        </div>

                                    </div><!-- End .summary -->
                                </aside><!-- End .col-lg-3 -->
                            </div><!-- End .row -->
                        </form>
                    </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <?php include("includ/footer.php") ?>

    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Set up the transaction details
                return actions.order.create({
                    purchase_units: [{
                        description: 'Your purchase description',
                        amount: {
                            currency_code: 'USD', // Change this to your currency code
                            value: '<?php echo number_format($totalPrice, 2); ?>' // Use the total price calculated in PHP
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Redirect to checkout_valide.php after a successful transaction
                    window.location.href = 'validation.php?validation=true';
                });
            }
        }).render('#paypal-button-container');
    </script>
    <?php
    include("includ/menu_telephone.php"); 
    include('header/ScriptHom.html'); 
    ?>
</body>

</html>