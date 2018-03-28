<!DOCTYPE html>
<html lang="nl">
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
        <?php
        echo pasStylesheetAan("eigenStijl.css");
        echo pasStylesheetAan("eigenStijl-tablet.css");
        echo pasStylesheetAan("eigenStijl-mobile.css");
        ?>

        <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row h-100">

                <!-- Menu -->

                <div class="pl-0 pr-0">
                    <nav class="hidden-xs-down sidebar h-100">
                        <div id="logo" class="d-flex align-items-center flex-column justify-content-center">
                            <div id="logo-wezenberg">Trainingscentrum</div>
                            <div id="logo-titel">WEZENBERG</div>
                            <div id="logo-titel-mobile">TCW</div>
                        </div>

                        <?php echo $menu; ?>
                    </nav>
                </div>

                <!-- Inhoud -->

                <div id="content" class="">

                    <!-- Hoofding -->

                    <div id="top-bar" class="row pl-2 pr-2 sticky-top">
                        <div id="top-bar-center" class="col d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <i class="material-icons mr-4" id="sidenav-toggler">menu</i>
                                <h2 class="hide-mobile-nav-open"><?php echo $titel ?></h2>
                            </div>
                            <div class="hide-mobile-nav-open">
                                <?php
                                setlocale(LC_TIME, 'nld_NLD');
                                echo strftime('%A, %d %B %Y');
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Inhoud -->

                    <main class="pt-4 pl-2 pr-2 hide-mobile-nav-open">
                        <?php echo $inhoud ?>
                    </main>

                    <!-- Voetnoot -->

                    <footer class="pl-2 pr-2 mt-5 hide-mobile-nav-open">
                        <div class="navbar-fixed-bottom text-center-sm text-left">
                            <div class="d-flex justify-content-md-between flex-lg-row flex-column">
                                <?php echo $voetnoot ?>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <?php echo haalJavascriptOp("eigenScript.js"); ?>
        <script>
            $(document).ready(function () {

                // Uitklapbare submenu voor de verticale menu

                $('.nav-link').on('click', function () {
                    $('.nav-link').removeClass('active');
                    $(this).toggleClass('active');
                });

                $('#sidenav-toggler').on('click', function () {
                    var breedte = $(window).width();
                    if (breedte > 768) {
                        if ($('#sidenav-toggler').text() === "menu") {
                            $('#sidenav-toggler').text('arrow_back');
                            $('link[rel=stylesheet][href*="eigenStijl-tablet.css"]').remove();
                        } else {
                            $('#sidenav-toggler').text('menu');
                            $('head').append('<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/eigenStijl-tablet.css">');
                        }
                    } else {
                        if ($('#sidenav-toggler').text() === "menu") {
                            $('#sidenav-toggler').text('arrow_back');
                            $('link[rel=stylesheet][href*="eigenStijl-mobile.css"]').remove();
                            $('link[rel=stylesheet][href*="eigenStijl-tablet.css"]').remove();
                            $('.hide-mobile-nav-open').css('display', 'none');
                        } else {
                            $('#sidenav-toggler').text('menu');
                            $('head').append('<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/eigenStijl-tablet.css">');
                            $('head').append('<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/eigenStijl-mobile.css">');
                            $('.hide-mobile-nav-open').css('display', 'block');
                        }
                    }
                });
            });
        </script>
    </body>

</html>
