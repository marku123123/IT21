<!-- loader.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loader</title>
    <link rel="stylesheet" href="style/loader.css">
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
        <div class="loader-message">Loading...</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(window).on("load", function() {
            setTimeout(function() {
                $(".loader-wrapper").fadeOut("slow", function() {
                    $(".loader-message").text("Page loaded!");
                });
            }, 125);
        });
    </script>
</body>

</html>