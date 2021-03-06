<?php 
/**
 * @file main_master.php
 * View waarmee de inhoud van de applicatie wordt weergegeven.
 */
?>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
        <?php
        echo pasStylesheetAan("eigenStijl.css");
        echo pasStylesheetAan("eigenStijl-tablet.css");
        echo pasStylesheetAan("eigenStijl-mobile.css");
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.nl-BE.min.js"></script>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row h-100">

                <!-- Menu -->

                <div class="pl-0 pr-0 navdiv">
                    <nav class="hidden-xs-down sidebar h-100 scroll-menu">
                        <div class="nav-height">
                            <div id="logo" class="d-flex align-items-center flex-column justify-content-center">
                                <div id="logo-wezenberg">Trainingscentrum</div>
                                <div id="logo-titel">WEZENBERG</div>
                                <div id="logo-titel-mobile">TCW</div>
                            </div>

                            <?php echo $menu; ?>
                        </div>
                    </nav>
                </div>

                <!-- Inhoud -->

                <div id="content" class="">

                    <!-- Hoofding -->

                    <div id="top-bar" class="row pl-2 pr-2 sticky-top">
                        <div id="top-bar-center" class="col d-flex align-items-center">
                            <i class="material-icons mr-4" id="sidenav-toggler">menu</i>
                            <div class="d-flex justify-content-sm-between text-right flex-column flex-sm-row w-100 align-items-sm-center">
                                <div class="">
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

                // Bij het resizen van je scherm de functie menuFooter() uitvoeren
                
                window.onresize = resize;
                function resize()
                {
                    menuFooter();
                }

                // Uitklapbare submenu voor de verticale menu

                $('.nav-link').on('click', function () {
                    $('.nav-link').removeClass('active');
                    $(this).toggleClass('active');
                    setTimeout(
                            function ()
                            {
                                menuFooter();
                            }, 250);
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

                menuFooter();

                // Wissel tussen position absolute en position relative bij menu-footer
                
                function menuFooter() {
                    if ($(".scroll-menu")[0].scrollHeight > $(".scroll-menu").height()) {
                        $('#menu-footer').removeClass('position-absolute');
                        $('#menu-footer').addClass('position-relative');
                        $('#menu-footer').css('bottom', '-10px');
                    } else {
                        $('#menu-footer').addClass('position-absolute');
                        $('#menu-footer').removeClass('position-relative');
                        $('#menu-footer').css('bottom', '10px');
                    }
                }
            });
        </script>
    </body>

</html>
