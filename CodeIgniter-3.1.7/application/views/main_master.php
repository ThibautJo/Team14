<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $titel ?></title>




        <?php echo pasStylesheetAan("eigenStijl.css"); ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js" />


        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Navigation -->
                <div class="col-2 collapse d-md-flex bg-light h-100" id="sidebar">
                    <ul class="nav flex-column flex-nowrap">
                        <li class="nav-item"><a class="nav-link" href="#">Profiel</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Agenda</a></li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#submenu1" data-toggle="collapse" data-target="#submenu1">Wedstrijden</a>
                            <div class="collapse" id="submenu1" aria-expanded="false">
                                <ul class="flex-column pl-2 nav">
                                    <li class="nav-item"><a class="nav-link py-0" href="">Orders</a></li>
                                    <li class="nav-item">
                                        <a class="nav-link collapsed py-1" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub1">Customers</a>
                                        <div class="collapse" id="submenu1sub1" aria-expanded="false">
                                            <ul class="flex-column nav pl-4">
                                                <li class="nav-item">
                                                    <a class="nav-link p-1" href="">
                                                        <i class="fa fa-fw fa-clock-o"></i> Daily
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link p-1" href="">
                                                        <i class="fa fa-fw fa-dashboard"></i> Dashboard
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link p-1" href="">
                                                        <i class="fa fa-fw fa-bar-chart"></i> Charts
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link p-1" href="">
                                                        <i class="fa fa-fw fa-compass"></i> Areas
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Meldingen</a></li>
                    </ul>
                </div>

                <!-- Page Content -->
                <div class="col">

                    <div class="row">
                        <div class="col-lg-12 text-info">
                            <?php echo $hoofding ?>
                        </div>
                    </div>
                    <br>
                    <!-- Page Features -->
                    <?php if (isset($geenRand)) { ?>
                        <div class="row">
                            <?php echo $inhoud; ?>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-lg-12 hero-feature">
                                <div class="thumbnail" style="padding: 20px">
                                    <div class="caption">
                                        <p>
                                            <?php echo $inhoud; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    <?php } ?>
                    <!-- /.row -->

                    <!-- Footer -->
                    <footer>
                        <div class="row navbar-fixed-bottom text-center">
                            <div class="col-lg-12">
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
