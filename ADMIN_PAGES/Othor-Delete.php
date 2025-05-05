<?php

include("verification.php");

$test_cherch = false;
$erreur = -1;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Cherche_auteur_delete'])) {
    // Assurez-vous de valider et nettoyer toutes les données du formulaire
    $nom_auteur = isset($_GET['cherch']) ? mysqli_real_escape_string($connexion, $_GET['cherch']) : '';
    // Requête SQL pour chercher les détails de l'auteur
    $query_chercher_auteur = "SELECT * FROM auteur WHERE nom_auteur LIKE '%$nom_auteur%' or prenom_auteur LIKE '%$nom_auteur%'";
    $result_chercher_auteur = mysqli_query($connexion, $query_chercher_auteur);

    if ($result_chercher_auteur) {
        // Vérifiez s'il y a des résultats
        if (mysqli_num_rows($result_chercher_auteur) > 0) {
            $test_cherch = true;
        } else {
            $erreur = 1;
            $message = "Author not found.";
        }
    } else {
        $erreur = 1;
        $message = "Error in query : " . mysqli_error($connexion);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['btn_delete'])) {

    $id_auteur = mysqli_real_escape_string($connexion, $_GET['id_auteur']);

    $query_chercher_auteur = "SELECT * FROM auteur WHERE id_auteur = '$id_auteur'";
    $result_chercher_auteur = mysqli_query($connexion, $query_chercher_auteur);

    if ($result_chercher_auteur && mysqli_num_rows($result_chercher_auteur) > 0) {

        $query_supprimer_auteur = "DELETE FROM auteur WHERE id_auteur = '$id_auteur'";
        $result_supprimer_auteur = mysqli_query($connexion, $query_supprimer_auteur);

        if ($result_supprimer_auteur) {
            $message = "Author successfully deleted.";
            $erreur = 0;
        } else {
            $message = "Error deleting author:" . mysqli_error($connexion);
            $erreur = 1;
        }
    } else {
        // Le auteur avec l'ID spécifié n'a pas été trouvé
        header("Location: 404.html");
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
                        <li class="breadcrumb-item active">Auteur Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Delete Auteur</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="true">Delete Othor</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                        <form action="Othor-Delete.php" method="get">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="delete-id" name="cherch" required placeholder="Cherch...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit" id="deleteSearchButton" name="Cherche_auteur_delete">
                                                            <i class="icon-search"></i>
                                                            <!-- Assuming you have an icon class for a magnifying glass -->
                                                        </button>
                                                    </div>
                                                </div>
                                            </div><!-- End .form-group -->
                                        </form>
                                        <?php if ($test_cherch) { ?>

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
                                                            <?php while ($row = mysqli_fetch_assoc($result_chercher_auteur)) { ?>
                                                                <form action="Othor-Delete.php" method="get">
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 70px;">
                                                                                <?php echo $row['id_auteur']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 90px;">
                                                                                <?php echo $row['nom_auteur']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="d-inline-block text-truncate" style="max-width: 90px;">
                                                                                <?php echo $row['prenom_auteur']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="">
                                                                                <!-- Ajoutez le signe égal dans la déclaration du value -->
                                                                                <input type="hidden" value="<?php echo $row['id_auteur']; ?>" name="id_auteur">
                                                                                <button type="submit" class="btn btn-danger" name="btn_delete" style="min-width: 80px;">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
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

</body>
<?php include("menu_telephone_admin.php"); ?>
</html>