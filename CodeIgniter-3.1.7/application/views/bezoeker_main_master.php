<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $titel ?></title>

        <!-- Stylesheets -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <?php echo pasStylesheetAan("bezoeker_eigenStijl.css"); ?>


        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>

        <!-- Navigatie -->

        <nav class="navbar navbar-expand-sm navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="#">TCW</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Startpagina</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Wedstrijden</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Team</a>
                        </li>
                        <li class="nav-item">
                            <a href="#">
                                <button type="button" class="btn btn-outline-light">
                                    Login
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="jumbotron jumbotron-fluid">
            <div id="background" class="container">
<!--                <h1 class="display-4">Fluid jumbotron</h1>
                <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>-->
                
            </div>
        </div>

        <footer>
            <div class="container pb-3">
                <div class="text-center">
                    <p>Trainingscentrum WEZENBERG</p>
                    <p id="footer-follow">Volg ons op <a href="https://www.facebook.com/Trainingscentrum-Wezenberg-TCW-514839802012875/"><i class="fa fa-facebook-square"></i></a> facebook</p>
                    <span class="col-1 d-flex justify-content-between">

                    </span>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <div class="col-6 d-flex justify-content-between">
                        <a href="#">Startpagina</a>
                        <a href="#">Wedstrijden</a>
                        <a href="#">Team</a>
                        <a href="#">Login</a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $(window).scroll(function () {
                    var scroll = $(window).scrollTop();
                    if (scroll > 54) {
                        $('nav').addClass("navbar-scrolling");
                    } else {
                        $('nav').removeClass("navbar-scrolling");
                    }
                });
            });

        </script>
    </body>

</html>
