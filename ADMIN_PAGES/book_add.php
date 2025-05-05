<?php

include("verification.php");

$message = '';
$test_ajout = -1;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Book_Add'])) {
    $titre_livre = mysqli_real_escape_string($connexion, $_POST['titre_livre']);
    $genre = mysqli_real_escape_string($connexion, $_POST['genre']);
    $id_auteur = mysqli_real_escape_string($connexion, $_POST['id_auteur']);
    $etat = mysqli_real_escape_string($connexion, $_POST['etat']);
    $Paragraphe = mysqli_real_escape_string($connexion, $_POST['Paragraphe']);
    $prix = mysqli_real_escape_string($connexion, $_POST['prix']);
    $reduction = mysqli_real_escape_string($connexion, $_POST['reduction']);
    $langue = mysqli_real_escape_string($connexion, $_POST['langue']);
    $date_publication = mysqli_real_escape_string($connexion, $_POST['date_publication']);

    // Debug information
    $debug_info = [];
    $debug_info[] = "Upload starting...";
    
    // Gestion de l'image
    $upload_success = false;
    $test_ajout = 0; // Default to error state unless everything succeeds
    
    if (isset($_FILES['img_livre']) && $_FILES['img_livre']['error'] === UPLOAD_ERR_OK) {
        $cover_temp = $_FILES['img_livre']['tmp_name'];
        $cover_name = $_FILES['img_livre']['name'];
        
        // Generate unique filename to avoid conflicts
        $cover_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $cover_name);
        
        // Use absolute paths relative to document root
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/PFA/book/img_livree/';
        $cover_path = $target_dir . $cover_name;
        
        $debug_info[] = "Image temp path: " . $cover_temp;
        $debug_info[] = "Image target path: " . $cover_path;
        
        // Ensure the directory exists
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                $debug_info[] = "Failed to create directory: " . $target_dir;
            } else {
                $debug_info[] = "Created directory: " . $target_dir;
            }
        }
        
        // Check if directory is writable
        if (!is_writable($target_dir)) {
            $debug_info[] = "Directory not writable: " . $target_dir;
            // Try to make it writable
            chmod($target_dir, 0777);
            $debug_info[] = "Attempted to change permissions on directory";
        }
        
        // Try to copy the file instead of move_uploaded_file
        if (copy($cover_temp, $cover_path)) {
            $debug_info[] = "Successfully copied image file";
            $upload_success = true;
        } else {
            $debug_info[] = "Failed to copy image. PHP error: " . error_get_last()['message'];
        }
        
        // If copy failed, try move_uploaded_file as fallback
        if (!$upload_success && move_uploaded_file($cover_temp, $cover_path)) {
            $debug_info[] = "Successfully moved image file";
            $upload_success = true;
        } else if (!$upload_success) {
            $debug_info[] = "Failed to move image. PHP error: " . error_get_last()['message'];
        }
        
        // If we succeeded with the image upload, continue with PDF
        if ($upload_success) {
            // Gestion du PDF
            if (isset($_FILES['Emplacement']) && $_FILES['Emplacement']['error'] === UPLOAD_ERR_OK) {
                $Emplacement_temp = $_FILES['Emplacement']['tmp_name'];
                $Emplacement_name = $_FILES['Emplacement']['name'];
                
                // Generate unique filename to avoid conflicts
                $Emplacement_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $Emplacement_name);
                
                // Use absolute paths relative to document root
                $pdf_dir = $_SERVER['DOCUMENT_ROOT'] . '/PFA/book/Emplacement/';
                $Emplacement_path = $pdf_dir . $Emplacement_name;
                
                $debug_info[] = "PDF temp path: " . $Emplacement_temp;
                $debug_info[] = "PDF target path: " . $Emplacement_path;
                
                // Ensure the directory exists
                if (!is_dir($pdf_dir)) {
                    if (!mkdir($pdf_dir, 0777, true)) {
                        $debug_info[] = "Failed to create PDF directory: " . $pdf_dir;
                    } else {
                        $debug_info[] = "Created PDF directory: " . $pdf_dir;
                    }
                }
                
                // Try to copy the file instead of move_uploaded_file
                $pdf_success = false;
                if (copy($Emplacement_temp, $Emplacement_path)) {
                    $debug_info[] = "Successfully copied PDF file";
                    $pdf_success = true;
                } else {
                    $debug_info[] = "Failed to copy PDF. PHP error: " . error_get_last()['message'];
                }
                
                // If copy failed, try move_uploaded_file as fallback
                if (!$pdf_success && move_uploaded_file($Emplacement_temp, $Emplacement_path)) {
                    $debug_info[] = "Successfully moved PDF file";
                    $pdf_success = true;
                } else if (!$pdf_success) {
                    $debug_info[] = "Failed to move PDF. PHP error: " . error_get_last()['message'];
                }
                
                if ($pdf_success) {
                    // Continue with database operations
                    // Update stored paths to be relative for database storage
                    $cover_name = 'book/img_livree/' . $cover_name;
                    $Emplacement_name = 'book/Emplacement/' . $Emplacement_name;
                    
                    // Rest of your database code follows...
                    // Vérifier si le livre existe déjà
                    $query_verification = "SELECT * FROM livre WHERE 
                                        titre_livre = ? AND 
                                        genre = ? AND 
                                        id_auteur = ? AND 
                                        etat = ?";

                    $stmt_verification = mysqli_prepare($connexion, $query_verification);
                    mysqli_stmt_bind_param(
                        $stmt_verification,
                        "siii",
                        $titre_livre,
                        $genre,
                        $id_auteur,
                        $etat
                    );

                    mysqli_stmt_execute($stmt_verification);
                    $result_verification = mysqli_stmt_get_result($stmt_verification);

                    if ($result_verification && mysqli_num_rows($result_verification) > 0) {
                        $test_ajout = 0;
                        $message = "Ce livre existe déjà dans la base de données.";
                    } else {
                        while (true) {
                            $ISBN = rand(10000000, 99999999);
                            $query_check_ID = "SELECT * FROM livre WHERE ISBN = ?";
                            $stmt_check_ID = mysqli_prepare($connexion, $query_check_ID);
                            mysqli_stmt_bind_param($stmt_check_ID, "s", $ISBN);
                            mysqli_stmt_execute($stmt_check_ID);
                            $result_check_ID = mysqli_stmt_get_result($stmt_check_ID);

                            if (mysqli_num_rows($result_check_ID) == 0) {
                                break;
                            }
                        }

                        $query_ajouter_book = "INSERT INTO livre (ISBN, titre_livre, genre, id_auteur, etat, img_livre, Emplacement, Paragraphe, prix, reduction,langue,date_publication) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";

                        $stmt_ajouter_book = mysqli_prepare($connexion, $query_ajouter_book);
                        mysqli_stmt_bind_param(
                            $stmt_ajouter_book,
                            "ssiiisssddss",
                            $ISBN,
                            $titre_livre,
                            $genre,
                            $id_auteur,
                            $etat,
                            $cover_name,
                            $Emplacement_name,
                            $Paragraphe,
                            $prix,
                            $reduction,
                            $langue,
                            $date_publication
                        );

                        if (mysqli_stmt_execute($stmt_ajouter_book)) {
                            $test_ajout = 1;
                            $message = "Livre ajouté avec succès dans la base de données.";
                        } else {
                            $test_ajout = 0;
                            $message = "Error adding data : " . mysqli_error($connexion);
                        }
                    }
                    mysqli_stmt_close($stmt_verification);
                } else {
                    $test_ajout = 0;
                    $message = "Error uploading PDF. " . implode(" | ", $debug_info);
                }
            } else {
                $test_ajout = 0;
                $message = "Error with PDF file: " . $_FILES['Emplacement']['error'];
            }
        } else {
            $test_ajout = 0;
            $message = "Error uploading image. " . implode(" | ", $debug_info);
        }
    } else {
        $test_ajout = 0;
        $message = "No image file selected or error in upload: " . (isset($_FILES['img_livre']) ? $_FILES['img_livre']['error'] : 'Not provided');
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
    <!-- <div id="preloader">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div> -->

    <div class="page-wrapper">
        <?php include("header_admin.php"); ?>

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Book</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#" role="tab" aria-controls="signin-2" aria-selected="false">Add book</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                    <form action="book_add.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="Titre">Title *</label>
                                            <input type="text" class="form-control" name="titre_livre" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="Titre">Price *</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="prix" step="0.01" required>
                                                <span class="input-group-text">&nbsp;&nbsp;$&nbsp;&nbsp;</span>
                                            </div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="Titre">Reduction *</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="reduction" step="0.01" required>
                                                <span class="input-group-text">&nbsp;&nbsp;%&nbsp;&nbsp;</span>
                                            </div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="Type">Gender *</label>
                                            <select id="pays" name="genre" class="form-control">
                                                <?php include("../includ/liste_genre.php"); ?>
                                            </select>

                                        </div><!-- End .form-group -->
                                        <div>
                                            <label for="Editeur">Editor *</label>
                                            <select id="pays" name="id_auteur" class="form-control">
                                                <?php
                                                // Fetch authors from the database
                                                $query_authors = "SELECT id_auteur, CONCAT(prenom_auteur, ' ', nom_auteur) AS full_name FROM auteur";
                                                $result_authors = mysqli_query($connexion, $query_authors);

                                                if ($result_authors && mysqli_num_rows($result_authors) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result_authors)) {
                                                        $id_auteur = $row['id_auteur'];
                                                        $full_name = $row['full_name'];
                                                        echo "<option value='$id_auteur'>$full_name</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Aucun auteur trouvé</option>";
                                                }
                                                ?>
                                            </select>

                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="langue">Language *</label>
                                            <select id="langue" name="langue" class="form-control" required>
                                                <option value="AR">Arab</option>
                                                <option value="FR">French</option>
                                                <option value="ENG">English</option>
                                            </select>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="date_publication">Publication date *</label>
                                            <input type="date" class="form-control" id="register-date-2" name="date_publication" required>
                                        </div><!-- End .form-group -->

                                        <div>
                                            <label for="Etat">State *</label>
                                            <select id="pays" name="etat" class="form-control">
                                                <option value="1">Available</option>
                                                <option value="0">Not available</option>
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
                                                        <p id="image-file-name">No file
                                                            chosen
                                                        </p>
                                                        <p>Drag and Drop</p>
                                                        <p>or</p>
                                                        <span class="browse-button">Cover</span>
                                                    </div>
                                                    <input type="file" id="image-file" accept="image/*" name="img_livre" required onchange="displayFileName('image-file')">
                                                </label>
                                            </div><!-- End .form-group -->

                                            <div class="col-sm-6">
                                                <label for="pdf-file" class="file-upload-label">
                                                    <div class="file-upload-design">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M4.5 11H4v1h.5a.5.5 0 0 0 0-1ZM7 5V.13a2.96 2.96 0 0 0-1.293.749L2.879 3.707A2.96 2.96 0 0 0 2.13 5H7Zm3.375 6H10v3h.375a.624.624 0 0 0 .625-.625v-1.75a.624.624 0 0 0-.625-.625Z" />
                                                            <path d="M19 7h-1V2a1.97 1.97 0 0 0-1.933-2H9v5a2 2 0 0 1-2 2H1a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h1a1.969 1.969 0 0 0 1.933 2h12.134c1.1 0 1.7-1.236 1.856-1.614a.988.988 0 0 0 .07-.386H19a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1ZM4.5 14H4v1a1 1 0 1 1-2 0v-5a1 1 0 0 1 1-1h1.5a2.5 2.5 0 1 1 0 5Zm8.5-.625A2.63 2.63 0 0 1 10.375 16H9a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1h1.375A2.63 2.63 0 0 1 13 11.625v1.75ZM17 12a1 1 0 0 1 0 2h-1v1a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2h-1v1h1Z" />
                                                        </svg>
                                                        <p id="pdf-file-name">No file chosen
                                                        </p>
                                                        <p>Drag and Drop</p>
                                                        <p>or</p>
                                                        <span class="browse-button">PDF</span>
                                                    </div>
                                                    <input type="file" id="pdf-file" accept=".pdf" name="Emplacement" required onchange="displayFileName('pdf-file')">
                                                </label>
                                            </div><!-- End .form-group -->



                                        </div>

                                        <div class="form-group">
                                            <label for="Paragraph">Paragraph *</label>
                                            <textarea name="Paragraphe" id="" cols="10" rows="1" class="form-control"></textarea>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <input type="submit" value="AJOUTER" class="btn btn-outline-primary-2" name="Book_Add">
                                        </div><!-- End .form-footer -->
                                    </form>

                                    <?php if ($test_ajout == 1) { ?>
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
                                    <?php } else if ($test_ajout == 0) { ?>

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

<script>
function displayFileName(inputId) {
    const input = document.getElementById(inputId);
    const fileNameDisplay = document.getElementById(inputId + '-name');
    
    if (input.files && input.files[0] && fileNameDisplay) {
        fileNameDisplay.textContent = input.files[0].name;
    }
}
</script>
</html>