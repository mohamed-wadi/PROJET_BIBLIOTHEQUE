<?php
include('connexion/test_connexion.php');
$id_client = $_SESSION['id_client'];

// Requête SQL pour récupérer toutes les informations du client
$query = "SELECT * FROM client WHERE id_client = $id_client";
$result = mysqli_query($connexion, $query);

if ($result) {
    // Vérifiez si des données ont été trouvées
    if (mysqli_num_rows($result) > 0) {
        $client = mysqli_fetch_assoc($result);

        // Afficher les informations du client
        $nom_client = $client['nom_client'];
        $prenom_client = $client['prenom_client'];
        $genre = $client['genre'];
        $Email = $client['Email'];
        $date_naissance = $client['date_naissance'];
        $country = $client['country'];
        $Date_inscription = $client['Date_inscription'];
        $MDP = $client['MDP'];
        $phone = $client['phone'];
        $role = $client['role'];


        // Libérer le résultat
        mysqli_free_result($result);
    } else {
        echo "Aucune information trouvée pour ce client.";
    }
} else {
    echo "Erreur de requête : " . mysqli_error($connexion);
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/dashboard.php  22 Nov 2019 10:03:13 GMT -->

<head>
    <?php include('header/HeadHom.html'); ?>
</head>

<body>

    <div class="page-wrapper">
        <?php
        if ($_SESSION['role'] == 'admin') {
            include("header/header_admin.php");
        } else {
            include("header/header_client.php");
        }
        ?>

        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">My Account</h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Account</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="dashboard">
                    <div class="container">
                        <div class="row">
                            <aside class="col-md-4 col-lg-3">
                                <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                                    </li>
                                    <?php if ($_SESSION['role'] == 'client') { ?>

                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account
                                            Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="connexion/Log_out.php">Sign Out</a>
                                    </li>
                                </ul>
                            </aside><!-- End .col-lg-3 -->

                            <div class="col-md-8 col-lg-9">
                                <div class="tab-content">
                                    <?php if ($_SESSION['role'] == 'client') { ?>
                                        <!-- For Clients -->
                                        <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                            <p>Welcome, <span class="font-weight-normal text-dark">
                                                    <?php echo htmlspecialchars($_SESSION['nom_client']); ?>
                                                </span>.
                                                <br>
                                                Explore your account dashboard where you can review your <a href="#tab-orders" class="tab-trigger-link link-underline">recent
                                                    orders</a>, manage <a href="#tab-address" class="tab-trigger-link">shipping
                                                    and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">update your password and
                                                    account details</a>.
                                            </p>
                                        </div><!-- .End .tab-pane -->
                                    <?php } ?>

                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                        <!-- For Administrators -->
                                        <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                            <p>Hello Administrator. (Not Administrator? <a href="Log_out.php">Logout</a>)
                                                <br>
                                                Manage user accounts, review order details, and execute administrative tasks
                                                seamlessly from your admin dashboard to ensure the system's optimal
                                                performance.
                                            </p>
                                        </div><!-- .End .tab-pane -->
                                    <?php } ?>



                                    <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
                                        <!-- <p>No downloads available yet.</p> -->
                                        <a href="checkout_valide.php" class="btn btn-outline-primary-2"><span>GO TO DOWNLOADS</span><i class="icon-long-arrow-right"></i></a>
                                    </div><!-- .End .tab-pane -->

                                    <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                        <p>The following addresses will be used on the checkout page by default.</p>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card card-dashboard">
                                                    <div class="card-body">
                                                        <h3 class="card-title">Address</h3>
                                                        <p>
                                                            <?php echo $nom_client . ' ' . $prenom_client ?><br>
                                                            <?php echo $country ?><br>
                                                            <?php echo $phone ?><br>
                                                            <?php echo $Email ?><br>
                                                        </p>
                                                    </div><!-- End .card-body -->
                                                </div><!-- End .card-dashboard -->
                                            </div><!-- End .col-lg-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- .End .tab-pane -->

                                    <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                        <form action="ADMIN_PAGES/User_Edit.php" method="post">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>First Name *</label>
                                                        <input type="text" class="form-control" name="nom_client" required value="<?= $client['prenom_client'] ?>">
                                                    </div><!-- End .col-sm-6 -->
                                                    <div class="col-sm-6">
                                                        <label>Last Name *</label>
                                                        <input type="text" class="form-control" name="prenom_client" required value="<?= $client['nom_client'] ?>">
                                                    </div><!-- End .col-sm-6 -->
                                                </div><!-- End .row -->
                                            </div><!-- End .form-group -->
                                            <div class="form-group">
                                                <label for="register-date-2">Date Of Birth *</label>
                                                <input type="date" class="form-control" id="register-date-2" name="date_naissance" required value="<?= $client['date_naissance'] ?>">
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="gender">Gender * :</label>
                                                <div class="form-check form-check-inline col-2">
                                                    <input class="form-check-input" type="radio" name="genre" id="inlineRadio1" value="woman">
                                                    <label class="form-check-label" for="inlineRadio1">Women</label>
                                                </div>

                                                <div class="form-check form-check-inline col-2">
                                                    <input class="form-check-input" type="radio" name="genre" id="inlineRadio2" value="man" checked>
                                                    <label class="form-check-label" for="inlineRadio2">Man</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <select id="pays" name="country" class="form-control" value="<?= $client['country'] ?>">
                                                            <option value="" selected>---</option>
                                                            <?php include("includ/list_contry.php"); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" name="phone" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" required value="<?= $client['phone'] ?>">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="register-email-2">Email *</label>
                                                <input type="email" class="form-control" id="register-email-2" name="Email" required value="<?= $client['Email'] ?>">
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="singin-password-2">Password *</label>
                                                <input type="password" class="form-control" id="singin-password-2" name="MDP" required value="<?= $client['MDP'] ?>">
                                            </div><!-- End .form-group -->

                                            <div class="form-footer">
                                                <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
                                                <button type="submit" class="btn btn-outline-primary-2" name="Edit">
                                                    <span>Edit</span>

                                                </button>
                                            </div><!-- End .form-footer -->
                                        </form>
                                    </div><!-- .End .tab-pane -->
                                </div>
                            </div><!-- End .col-lg-9 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <?php if ($_SESSION['role'] == 'client') {
            include("includ/footer.php");
        } ?>

    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <?php 
    if ($_SESSION['role'] == 'admin') {
        include("includ/menu_telephone_admin.php");
    } else {
        include("includ/menu_telephone.php");
    }
    include('header/ScriptHom.html'); 
    ?>
</body>



</html>