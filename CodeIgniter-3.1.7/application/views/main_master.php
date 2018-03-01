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

                <!-- Sidenav -->

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
                            <p class="text-white pt-2 mb-0">PieterTimmers</p>
                        </div>

                        <ul class="nav nav-pills flex-column" id="sidenav">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#profielSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="profielSubMenu"><i class="material-icons md-18 mr-3">person</i> Profiel</a>
                                <div id="submenu" class="kleur">
                                    <ul class="collapse list-unstyled pl-4" id="profielSubMenu" data-parent="#sidenav">
                                        <li class="pt-2">
                                            <a class="nav-link1" href="#">Profiel</a>
                                        </li>
                                        <li class="pb-2">
                                            <a class="nav-link1" href="#">Aanpassen</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#"><i class="material-icons md-18 mr-3">event_note</i>Agenda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#wedstrijdSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="wedstrijdSubMenu"><i class="material-icons md-18 mr-3">flag</i>Wedstrijden</a>  
                                <div id="submenu" class="kleur">
                                    <ul class="collapse list-unstyled pl-4" id="wedstrijdSubMenu" data-parent="#sidenav">
                                        <li class="pt-2">
                                            <a class="nav-link1" href="#">Wedstrijden</a>
                                        </li>
                                        <li>
                                            <a class="nav-link1" href="#">Wedstrijdresultaten</a>
                                        </li>
                                        <li class="pb-2">
                                            <a class="nav-link1" href="#">Inschrijven</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#"><i class="material-icons md-18 mr-3">group</i>Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex justify-content-between align-items-center" href="#"><span class="d-flex align-items-center"><i class="material-icons md-18 mr-3">notifications</i>Meldingen</span> <div id="melding-menu" class="img-circle d-flex align-items-center justify-content-center">2</div></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Scrollable -->

                <div class="col-10">
                    <div id="top-bar" class="row">
                        <div class="col d-flex align-items-center justify-content-between">
                            <h2><?php echo $titel ?></h2>
                            <div>
                                <?php
                                echo date("d F Y");
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->

                    <main class="pt-2">
                    </main>

                    <!-- Footer -->

                    <footer>
                        <div class="navbar-fixed-bottom text-center">
                            <div class="">
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
