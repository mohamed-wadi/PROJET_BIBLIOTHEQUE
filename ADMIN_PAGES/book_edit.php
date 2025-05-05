<?php

include("verification.php");

$test_cherch = false;
$cherch = 0;
$erreur = -1;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Cherche_book_edit'])) {
    $titre_book = isset($_GET['cherch']) ? mysqli_real_escape_string($connexion, $_GET['cherch']) : '';

    $query_chercher_book = "SELECT * FROM livre WHERE titre_livre LIKE '%$titre_book%'";
    $result_chercher_book = mysqli_query($connexion, $query_chercher_book);

    if ($result_chercher_book) {
        if (mysqli_num_rows($result_chercher_book) > 0) {
            $test_cherch = true;
            $cherch = 1;
        } else {
            $erreur = 1;
            $message = "Book not found.";
        }
    } else {
        $erreur = 1;
        $message = "Error in query: " . mysqli_error($connexion);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_edit'])) {
    $ISBN = mysqli_real_escape_string($connexion, $_POST['ISBN']);

    $query_chercher_book = "SELECT * FROM livre WHERE ISBN = '$ISBN'";
    $result_chercher_book = mysqli_query($connexion, $query_chercher_book);

    if ($result_chercher_book && mysqli_num_rows($result_chercher_book) > 0) {
        $book = mysqli_fetch_assoc($result_chercher_book);

        $test_cherch = true;
        $cherch = 2;
    } else {
        header("Location: 404.html");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Edit'])) {

    $ISBN = mysqli_real_escape_string($connexion, $_POST['ISBN']);
    $titre_livre = mysqli_real_escape_string($connexion, $_POST['titre_livre']);
    $genre = mysqli_real_escape_string($connexion, $_POST['genre']);
    $id_auteur = mysqli_real_escape_string($connexion, $_POST['id_auteur']);
    $etat = mysqli_real_escape_string($connexion, $_POST['etat']);
    $prix = mysqli_real_escape_string($connexion, $_POST['prix']);
    $reduction = mysqli_real_escape_string($connexion, $_POST['reduction']);
    $Paragraphe = mysqli_real_escape_string($connexion, $_POST['Paragraphe']);
    $langue = mysqli_real_escape_string($connexion, $_POST['langue']);
    $date_publication = mysqli_real_escape_string($connexion, $_POST['date_publication']);


    $img_livre = $Emplacement = '';

    if (!empty($_FILES['img_livre']['name'])) {
        $cover_temp = $_FILES['img_livre']['tmp_name'];
        $cover_name = mysqli_real_escape_string($connexion, $_FILES['img_livre']['name']);
        $cover_path = 'C:/xampp/htdocs/SHM_Bibliotheque/book/img_livree/' . $cover_name;

        if (move_uploaded_file($cover_temp, $cover_path)) {
            $img_livre = 'book/img_livree/' . $cover_name;
        } else {
            $erreur = 1;
            $message = "Erreur lors du téléchargement de l'image.";
        }
    }

    if (!empty($_FILES['Emplacement']['name'])) {
        $Emplacement_temp = $_FILES['Emplacement']['tmp_name'];
        $Emplacement_name = mysqli_real_escape_string($connexion, $_FILES['Emplacement']['name']);
        $Emplacement_path = 'C:/xampp/htdocs/SHM_Bibliotheque/book/Emplacement/' . $Emplacement_name;

        if (move_uploaded_file($Emplacement_temp, $Emplacement_path)) {
            $Emplacement = 'book/Emplacement/' . $Emplacement_name;
        } else {
            $erreur = 1;
            $message = "Error downloading PDF location.";
        }
    }


    if (!empty($img_livre) && !empty($Emplacement)) {
        $query_modifier_book = "UPDATE livre SET titre_livre = ?, genre = ?, id_auteur = ?, etat = ?, img_livre = ?, Emplacement = ?, Paragraphe = ?, prix=?, reduction=?,langue=?,date_publication=? WHERE ISBN = ?";
        $stmt = mysqli_prepare($connexion, $query_modifier_book);
        mysqli_stmt_bind_param($stmt, "siiisssddsss", $titre_livre, $genre, $id_auteur, $etat, $img_livre, $Emplacement, $Paragraphe, $prix, $reduction, $langue, $date_publication, $ISBN);

        if (mysqli_stmt_execute($stmt)) {
            $erreur = 0;
            $message = "Book edited successfully.";
        } else {
            $erreur = 1;
            $message = "Error editing book : " . mysqli_error($connexion);
        }
        mysqli_stmt_close($stmt);
    } elseif (!empty($img_livre) && empty($Emplacement)) {
        $query_modifier_book = "UPDATE livre SET titre_livre = ?, genre = ?, id_auteur = ?, etat = ?, img_livre = ?, Paragraphe = ?, prix=?, reduction=?,langue=?,date_publication=? WHERE ISBN = ?";
        $stmt = mysqli_prepare($connexion, $query_modifier_book);
        mysqli_stmt_bind_param($stmt, "siiissddsss", $titre_livre, $genre, $id_auteur, $etat, $img_livre, $Paragraphe, $prix, $reduction, $langue, $date_publication, $ISBN);

        if (mysqli_stmt_execute($stmt)) {
            $erreur = 0;
            $message = "Book edited successfully.";
        } else {
            $erreur = 1;
            $message = "Error editing book : " . mysqli_error($connexion);
        }
        mysqli_stmt_close($stmt);
    } elseif (empty($img_livre) && !empty($Emplacement)) {
        $query_modifier_book = "UPDATE livre SET titre_livre = ?, genre = ?, id_auteur = ?, etat = ?, Emplacement = ?, Paragraphe = ?, prix=?, reduction=?,langue=?,date_publication=? WHERE ISBN = ?";
        $stmt = mysqli_prepare($connexion, $query_modifier_book);
        mysqli_stmt_bind_param($stmt, "siiissddsss", $titre_livre, $genre, $id_auteur, $etat, $Emplacement, $Paragraphe, $prix, $reduction, $langue, $date_publication, $ISBN);

        if (mysqli_stmt_execute($stmt)) {
            $erreur = 0;
            $message = "Book edited successfully.";
        } else {
            $erreur = 1;
            $message = "Error editing book : " . mysqli_error($connexion);
        }
        mysqli_stmt_close($stmt);
    } else {
        $query_modifier_book = "UPDATE livre SET titre_livre = ?, genre = ?, id_auteur = ?, etat = ?,Paragraphe = ?, prix=?, reduction=?,langue=?,date_publication=? WHERE ISBN = ?";
        $stmt = mysqli_prepare($connexion, $query_modifier_book);
        mysqli_stmt_bind_param($stmt, "ssiisddsss", $titre_livre, $genre, $id_auteur, $etat, $Paragraphe, $prix, $reduction, $langue, $date_publication, $ISBN);

        if (mysqli_stmt_execute($stmt)) {
            $erreur = 0;
            $message = "Book edited successfully.";
        } else {
            $erreur = 1;
            $message = "Error editing book : " . mysqli_error($connexion);
        }
        mysqli_stmt_close($stmt);
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
                        <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>>
                        <li class="breadcrumb-item">Book Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Book</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#" role="tab" aria-controls="signin-2" aria-selected="false">Edit book</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                    <form action="book_edit.php" method="get">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="delete-id" name="cherch" required placeholder="Cherch...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit" id="deleteSearchButton" name="Cherche_book_edit">
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
                                                            <th class="text-center">Cover</th>
                                                            <th class="text-center">Titre</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = mysqli_fetch_assoc($result_chercher_book)) { ?>
                                                            <form action="book_edit.php" method="post">
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <figure class="product-media" style="max-width: 70px;margin-left: 20px;">
                                                                            <a href="#">
                                                                                <img src="../<?php echo $row['img_livre']; ?>" alt="Product image">
                                                                            </a>
                                                                        </figure>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="d-inline-block text-truncate" style="max-width: 90px;">
                                                                            <?php echo $row['titre_livre']; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="">
                                                                            <!-- Ajoutez le signe égal dans la déclaration du value -->
                                                                            <input type="hidden" value="<?php echo $row['ISBN']; ?>" name="ISBN">
                                                                            <button type="submit" class="btn btn-danger" name="btn_edit" style="min-width: 80px;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                                                </svg>
                                                                                <!-- <span>Edit</span> -->
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
                                        <form action="book_edit.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="Titre">Title *</label>
                                                <input type="text" class="form-control" id="register-date-2" name="titre_livre" value="<?= $book['titre_livre'] ?>" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="Titre">Price *</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="prix" step="0.01" value="<?= $book['prix'] ?>">
                                                    <span class="input-group-text">&nbsp;&nbsp;$&nbsp;&nbsp;</span>
                                                </div>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="Titre">Reduction *</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="reduction" step="0.01" value="<?= $book['reduction'] ?>">
                                                    <span class="input-group-text">&nbsp;&nbsp;%&nbsp;&nbsp;</span>
                                                </div>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="Type">Gender *</label>
                                                <select id="genre" name="genre" class="form-control">
                                                    <option value="<?= $book['genre'] ?>"><?= $book['genre'] ?></option>
                                                    <?php include("../includ/liste_genre.php"); ?>
                                                </select>

                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="Editeur">Editor *</label>
                                                <select id="auteur" name="id_auteur" class="form-control">
                                                    <?php
                                                    // Fetch authors from the database
                                                    $query_authors = "SELECT id_auteur, CONCAT(prenom_auteur, ' ', nom_auteur) AS full_name FROM auteur";
                                                    $result_authors = mysqli_query($connexion, $query_authors);

                                                    if ($result_authors && mysqli_num_rows($result_authors) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result_authors)) {
                                                            $id_auteur = $row['id_auteur'];
                                                            $full_name = $row['full_name'];
                                                            $selected = ($id_auteur == $book['id_auteur']) ? 'selected' : '';
                                                            echo "<option value='$id_auteur' $selected>$full_name</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>--</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="langue">Language *</label>
                                                <select id="langue" name="langue" class="form-control" required>
                                                    <option value="AR" <?= ($book['langue'] == 'AR') ? 'selected' : '' ?>>Arab</option>
                                                    <option value="FR" <?= ($book['langue'] == 'FR') ? 'selected' : '' ?>>French</option>
                                                    <option value="ENG" <?= ($book['langue'] == 'ENG') ? 'selected' : '' ?>>English</option>
                                                </select>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="date_publication">Publication date *</label>
                                                <input type="date" class="form-control" id="register-date-2" name="date_publication" value="<?= $book['date_publication'] ?>" required>
                                            </div><!-- End .form-group -->


                                            <div>
                                                <label for="Etat">State *</label>
                                                <select id="pays" name="etat" class="form-control">
                                                    <option value="1">Disponible</option>
                                                    <option value="0">Non disponible</option>
                                                </select>

                                            </div><!-- End .form-group -->

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label for="image-file" class="file-upload-label">
                                                        <div class="file-upload-design">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                                                <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                                                                <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                                                            </svg>
                                                            <?php
                                                            $imageFileName = isset($book['img_livre'])
                                                                ? substr($book['img_livre'], 0, 8) . '....' . pathinfo($book['img_livre'], PATHINFO_EXTENSION)
                                                                : 'No file chosen';
                                                            ?>
                                                            <p id="image-file-name" style="color:red">
                                                                <?php echo htmlspecialchars($imageFileName); ?>
                                                            </p>
                                                            <p>Drag and Drop</p>
                                                            <p>or</p>
                                                            <span class="browse-button">Cover</span>
                                                        </div>
                                                        <input type="file" id="image-file" accept="image/*" name="img_livre" value="<?php echo isset($book['img_livre']) ? $book['img_livre'] : ''; ?>" onchange="displayFileName('image-file')">
                                                    </label>
                                                </div><!-- End .form-group -->

                                                <div class="col-sm-6">
                                                    <label for="pdf-file" class="file-upload-label">
                                                        <div class="file-upload-design">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M4.5 11H4v1h.5a.5.5 0 0 0 0-1ZM7 5V.13a2.96 2.96 0 0 0-1.293.749L2.879 3.707A2.96 2.96 0 0 0 2.13 5H7Zm3.375 6H10v3h.375a.624.624 0 0 0 .625-.625v-1.75a.624.624 0 0 0-.625-.625Z" />
                                                                <path d="M19 7h-1V2a1.97 1.97 0 0 0-1.933-2H9v5a2 2 0 0 1-2 2H1a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h1a1.969 1.969 0 0 0 1.933 2h12.134c1.1 0 1.7-1.236 1.856-1.614a.988.988 0 0 0 .07-.386H19a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1ZM4.5 14H4v1a1 1 0 1 1-2 0v-5a1 1 0 0 1 1-1h1.5a2.5 2.5 0 1 1 0 5Zm8.5-.625A2.63 2.63 0 0 1 10.375 16H9a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1h1.375A2.63 2.63 0 0 1 13 11.625v1.75ZM17 12a1 1 0 0 1 0 2h-1v1a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2h-1v1h1Z" />
                                                            </svg>
                                                            <?php
                                                            $pdfFileName = !empty($book['Emplacement']) ? substr($book['Emplacement'], 0, 8) . '....' . pathinfo($book['Emplacement'], PATHINFO_EXTENSION) : 'No file chosen';
                                                            ?>
                                                            <p id="pdf-file-name" style="color:red">
                                                                <?php echo htmlspecialchars($pdfFileName); ?>
                                                            </p>

                                                            <p>Drag and Drop</p>
                                                            <p>or</p>
                                                            <span class="browse-button">PDF</span>
                                                        </div>
                                                        <input type="file" id="pdf-file" accept=".pdf" name="Emplacement" value="<?= $book['Emplacement'] ?>" onchange="displayFileName('pdf-file')">
                                                    </label>
                                                </div><!-- End .form-group -->

                                            </div>

                                            <div class="form-group">
                                                <label for="Paragraph">Paragraph *</label>
                                                <textarea name="Paragraphe" id="" cols="10" rows="1" class="form-control"><?php echo $book['Paragraphe'] ?></textarea>
                                            </div><!-- End .form-group -->

                                            <div class="form-footer">
                                                <input type="hidden" name="ISBN" value="<?= $book['ISBN'] ?>">
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