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
        <?php echo pasStylesheetAan("eigenStijl.css"); ?>
        
        
        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row h-100">

                <!-- Menu -->

                <div class="col-2 pl-0 pr-0">
                    <nav class="hidden-xs-down sidebar h-100">
                        <div id="logo" class="d-flex align-items-center flex-column justify-content-center">
                            <div>Trainingscentrum</div>
                            <div id="logo-titel">WEZENBERG</div>
                        </div>

                        <div id="account-foto" class="d-flex align-items-center flex-column justify-content-center">
                            <div>
                                <?php
                                echo toonAfbeelding('Profiel/Avatar_Pieter Timmers.png', 'width="125px" class="shadow img-circle"');
                                ?>
                            </div>
                            <p class="text-white pt-2 mb-0">Pieter Timmers</p>
                        </div>

                        <?php echo $menu; ?>
                        
                        <!-- Voetnoot menu -->
                            <div id="menu-footer" class="d-flex align-items-end position-absolute col-12">
                                <p class="col-12 text-center">&copy; Trainingscentrum Wezenberg</p>
                            </div>
                    </nav>
                </div>
              
                <!-- Inhoud -->

                <div id="content" class="col-10">
                    
                    <!-- Hoofding -->
                    
                    <div id="top-bar" class="row pl-2 pr-2">
                        <div class="col d-flex align-items-center justify-content-between">
                            <h2><?php echo $titel ?></h2>
                            <div>
                                <?php
                                echo date("d F Y");
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Inhoud -->

                    <main class="pt-4 pl-2 pr-2">
                        <?php echo $inhoud ?>
                    </main>

                    <!-- Voetnoot -->

                    <footer class="pl-2 pr-2">
                        <div class="navbar-fixed-bottom text-center">
                            <div class="d-flex justify-content-between">
                                <?php echo $voetnoot ?>                       
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Scripts -->

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {

                $('.nav-link').on('click', function () {
                    $('.nav-link').removeClass('active');
                    $(this).toggleClass('active');
                });
            });
        </script>
    </body>

</html>
