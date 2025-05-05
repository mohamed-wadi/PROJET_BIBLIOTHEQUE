<?php
include("verification.php");

$test_cherch = false;
$cherch = 0;
$erreur = -1;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Cherche_client_edit'])) {
    // Assurez-vous de valider et nettoyer toutes les données du formulaire
    $nom_client = isset($_GET['cherch']) ? $_GET['cherch'] : '';
    // Requête SQL pour chercher les détails de l'client
    $query_chercher_client = "SELECT * FROM client WHERE nom_client LIKE ? OR prenom_client LIKE ?";
    $stmt_chercher_client = mysqli_prepare($connexion, $query_chercher_client);
    $nom_client_param = "%$nom_client%";
    mysqli_stmt_bind_param($stmt_chercher_client, "ss", $nom_client_param, $nom_client_param);
    mysqli_stmt_execute($stmt_chercher_client);
    $result_chercher_client = mysqli_stmt_get_result($stmt_chercher_client);

    if ($result_chercher_client) {
        // Vérifiez s'il y a des résultats
        if (mysqli_num_rows($result_chercher_client) > 0) {
            $test_cherch = true;
            $cherch = 1;
        } else {
            $message = "client non trouvé.";
        }
    } else {
        // Gestion des erreurs de la requête
        $message = "Erreur dans la requête : " . mysqli_error($connexion);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['btn_edit'])) {

    // Assurez-vous de valider et nettoyer toutes les données du formulaire
    $id_client = $_GET['id_client'];

    // Requête SQL pour chercher les détails de l'client
    $query_chercher_client = "SELECT * FROM client  WHERE id_client = ?";
    $stmt_chercher_client = mysqli_prepare($connexion, $query_chercher_client);
    mysqli_stmt_bind_param($stmt_chercher_client, "s", $id_client);
    mysqli_stmt_execute($stmt_chercher_client);
    $result_chercher_client = mysqli_stmt_get_result($stmt_chercher_client);

    if ($result_chercher_client && mysqli_num_rows($result_chercher_client) > 0) {
        $client = mysqli_fetch_assoc($result_chercher_client);

        $test_cherch = true;
        $cherch = 2;
    } else {
        header("Location: 404.html");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Edit'])) {

    $id_client = $_POST['id_client'];
    $nom_client = $_POST['nom_client'];
    $prenom_client = $_POST['prenom_client'];
    $date_naissance = $_POST['date_naissance'];
    $genre = $_POST['genre'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $Email = $_POST['Email'];
    $MDP = $_POST['MDP'];
    $role=$_POST['role'];

    // Mettez à jour les détails de l'utilisateur dans la base de données
    $query_modifier_utilisateur = "UPDATE client SET nom_client = ?, prenom_client = ?, genre = ?, country = ?, phone = ?, Email = ?, MDP = ? , role = ? WHERE id_client = ?";
    $stmt_modifier_utilisateur = mysqli_prepare($connexion, $query_modifier_utilisateur);
    mysqli_stmt_bind_param($stmt_modifier_utilisateur, "sssssssss", $nom_client, $prenom_client, $genre, $country, $phone, $Email, $MDP,$role, $id_client);
    $result_modifier_utilisateur = mysqli_stmt_execute($stmt_modifier_utilisateur);

    if ($result_modifier_utilisateur) {
        $erreur = 0;
        $message = "client modified successfully.";
    } else {
        $erreur = 1;
        $message = "Error when modifying user: " . mysqli_error($connexion);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("../ADMIN_PAGES/head.html");
    include("../ADMIN_PAGES/script.html");
    ?>
</head>

<body>
    <div class="page-wrapper">

        <?php include("header_admin.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="true">Edit User</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                        <form action="User_Edit.php" method="get">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="delete-id" name="cherch" required placeholder="Cherch...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit" id="deleteSearchButton" name="Cherche_client_edit">
                                                            <i class="icon-search"></i>
                                                            <!-- Assuming you have an icon class for a magnifying glass -->
                                                        </button>
                                                    </div>
                                                </div>
                                            </div><!-- End .form-group -->
                                        </form>
                                        <?php if ($test_cherch && $cherch == 1) { ?>

                                            <div class="form-group">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th class="text-center">ID</th>
                                                                <th class="text-center">Nom</th>
                                                                <th class="text-center">Prenom</th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($row = mysqli_fetch_assoc($result_chercher_client)) { ?>
                                                                <form action="User_Edit.php" method="get">
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 70px;">
                                                                                <?php echo $row['id_client']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 90px;">
                                                                                <?php echo $row['nom_client']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 90px;">
                                                                                <?php echo $row['prenom_client']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="">
                                                                                <!-- Ajoutez le signe égal dans la déclaration du value -->
                                                                                <input type="hidden" value="<?php echo $row['id_client']; ?>" name="id_client">
                                                                                <button type="submit" class="btn btn-danger" name="btn_edit" style="min-width: 80px;">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </form>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div><!-- End .form-group -->

                                        <?php } ?>


                                        <?php if ($test_cherch && $cherch == 2) { ?>
                                            <form action="User_Edit.php" method="post">
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
                                                        <input class="form-check-input" type="radio" name="genre" id="inlineRadio1" value="woman" <?= ($client['genre'] === 'woman') ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="inlineRadio1">Women</label>
                                                    </div>

                                                    <div class="form-check form-check-inline col-2">
                                                        <input class="form-check-input" type="radio" name="genre" id="inlineRadio2" value="man" <?= ($client['genre'] === 'man') ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="inlineRadio2">Man</label>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="register-date-2">Country *</label>
                                                            <select id="pays" name="country" class="form-control" value="<?= $client['country'] ?>">
                                                                <?php include("contry.html"); ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <label for="register-date-2">Number *</label>
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

                                                <div class="form-group">
                                                    <label for="Etat">Role *</label>
                                                    <select id="pays" name="role" class="form-control" value="<?= $client['role'] ?>">
                                                        <option value="client">Client</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div><!-- End .form-group -->


                                                <div class="form-footer">
                                                    <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
                                                    <button type="submit" class="btn btn-outline-primary-2" name="Edit">
                                                        <span>Edit</span>
                                                    </button>
                                                </div><!-- End .form-footer -->
                                            </form>
                                        <?php } ?>

                                        <?php if ($erreur == 0) { ?>
                                            <div class="info">
                                                <div class="info__icon">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                    </svg>
                                                </div>
                                                <div class="info__title">
                                                    <?php echo $message ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($erreur == 1) { ?>
                                            <div class="error">
                                                <div class="error__icon">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                    </svg>
                                                </div>
                                                <div class="error__title">
                                                    <?php echo $message ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div><!-- .End .tab-pane -->
                                </div><!-- End .tab-content -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php include("menu_telephone_admin.php"); ?>
</body>

</html>