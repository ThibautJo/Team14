<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $titel ?></title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <?php echo pasStylesheetAan("eigenStijl.css"); ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js" />
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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
                            <div class="">
                                <?php
                                echo toonAfbeelding('Profiel/Avatar_Pieter Timmers.png', 'width="125px" class="shadow img-circle"');
                                ?>
                            </div>
                            <p class="text-white pt-2 mb-0">Pieter Timmers</p>
                        </div>
                        
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Profiel <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Agenda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Wedstrijden</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Meldingen</a>
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


        <!-- /.container -->

    </body>

</html>
