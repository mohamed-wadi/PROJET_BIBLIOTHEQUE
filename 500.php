<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'header/HeadHom.html'; ?>
    </head>
    <body>
        <div class="page-wrapper">
            <main class="main">
                <div class="error-content text-center" style="background-image: url(assets/images/backgrounds/error-bg.jpg)">
                    <div class="container">
                        <h1 class="error-title">Error 500</h1>
                        <p>Internal Server Error. We apologize for the inconvenience.</p>
                        <?php session_start();
                        if ($_SESSION['role'] == "admin") { ?>
                            <a href="ADMIN_PAGES/index_admin.php" class="btn btn-outline-primary-2 btn-minwidth-lg">
                                <span>BACK TO HOMEPAGE</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        <?php } else { ?>
                            <a href="index.php" class="btn btn-outline-primary-2 btn-minwidth-lg">
                                <span>BACK TO HOMEPAGE</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>