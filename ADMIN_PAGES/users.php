<?php
include("verification.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['btn_delete'])) {

    $id_client = mysqli_real_escape_string($connexion, $_GET['id_client']);

    $query_chercher_client = "SELECT * FROM client WHERE id_client = '$id_client'";
    $result_chercher_client = mysqli_query($connexion, $query_chercher_client);

    if ($result_chercher_client && mysqli_num_rows($result_chercher_client) > 0) {

        $query_supprimer_client = "DELETE FROM client WHERE id_client = '$id_client'";
        $result_supprimer_client = mysqli_query($connexion, $query_supprimer_client);

        if ($result_supprimer_client) {
            $message = "Client successfully deleted.";
            $erreur = 0;
        } else {
            $message = "Error deleting client:" . mysqli_error($connexion);
            $erreur = 1;
        }
    } else {
        // Le client avec l'ID spécifié n'a pas été trouvé
        header("Location: 404.html");
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SHM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link href="../Admin_Style/assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../Admin_Style/assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../Admin_Style/assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="../Admin_Style/assets/css/master.css" rel="stylesheet">
    <link href="../Admin_Style/assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../Admin_Style/style_livre.css" rel="stylesheet">
    <link href="../Admin_Style/style.css" rel="stylesheet">

    <?php
    include("../ADMIN_PAGES/script.html");
    ?>

</head>



<body>
    <div class="page-wrapper">
        <?php include("header_admin.php"); ?>
        <main class="main">
            <div class="page-header text-center" style="background-image: url('../assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">Customer<span>Pages</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customer</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
                <table id="example" class="table table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of birth</th>
                            <th>Gender</th>
                            <th>Country</th>
                            <th>Registration date</th>
                            <th>Modify - Delete</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        // Requête pour récupérer les données des clients
                        $sql = "SELECT id_client, nom_client, prenom_client, genre, date_naissance, country, Date_inscription FROM client WHERE role != 'admin'";
                        $result = $connexion->query($sql);

                        // Vérifier s'il y a des résultats
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($row["prenom_client"]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row["nom_client"]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row["date_naissance"]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row["genre"]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row["country"]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row["Date_inscription"]); ?>
                                    </td>
                                    <td>
                                        <div class='ED'>
                                            <form action='users.php' method='get'>
                                                <input type='hidden' name='id_client' value='<?php echo $row["id_client"]; ?>'>
                                                <button type='submit' class='btn btn-danger' name='btn_delete' style="min-width: 30px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action='User_Edit.php' method='get'>
                                                <input type='hidden' name='id_client' value='<?php echo $row["id_client"]; ?>'>
                                                <button type='submit' class='btn btn-info' name='btn_edit' style="min-width: 30px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php include("menu_telephone_admin.php"); ?>
</body>

</html>