<!DOCTYPE html>
<html lang="en">

<body>
    <div class="cta-newsletter text-center pt-6 pb-7">
        <div class="container">
            <span class="cta-icon"><i class="icon-envelope"></i></span>
            <h3 class="title">Subscribe for Our Newsletter</h3><!-- End .title -->
            <p class="title-desc">Learn about new offers and get more deals by joining our newsletter</p>
            <!-- End .title-desc -->

            <form id="subscribeForm" method="post">
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="Enter your Email Address" aria-label="Email Adress"
                        aria-describedby="newsletter-btn" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="newsletter-btn"
                            name="SUBSCRIBE"><span>SUBSCRIBE</span><i class="icon-long-arrow-right"></i></button>
                    </div><!-- .End .input-group-append -->
                </div><!-- .End .input-group -->
            </form>
        </div><!-- End .container -->
    </div><!-- End .cta-newsletter -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#subscribeForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'subscribe.php',
                data: formData,
                success: function(response) {
                    var responseData = JSON.parse(response);

                    var icon = document.getElementById("icon");
                    if (responseData.icon == 1) {
                        icon.innerHTML =
                            '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path color="green" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>';
                    }
                    if (responseData.icon == 2) {
                        icon.innerHTML =
                            '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-question-octagon-fill" viewBox="0 0 16 16"><path color="red" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927" /></svg>';
                    }

                    var message = document.getElementById("message");
                    message.textContent = responseData.message;

                    $('#ModalCenter').modal('show');
                }
            });
        });
    });
    </script>
</body>

</html>