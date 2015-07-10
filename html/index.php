<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quinyx Sales Forecasts</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../../html/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../../../html/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../../../../html/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../../html/css/scrolling-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Sales Forecasts</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <!--<li>
                        <a class="page-scroll" href="#geolocate">Change Geo Coordinates</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <section id="intro" class="intro-section">
        <div class="container">
            <table id="sales-forecasts" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Initial Forecast</th>
                        <th>Updated Forecast</th>
                        <th>Temperature</th>
                        <th>Average Rainfall</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($updatedForecast as $forecast) {
                            if(is_numeric($forecast[1])) {
                                $date = date('Y-m-d H:i:s D', strtotime($forecast[0]));
                                $temp = ($forecast[3] !== null)? $forecast[3] : "No weather forecast";
                                $rain = ($forecast[4] !== null)? $forecast[4] : "No weather forecast";
                                echo "
                                    <tr>
                                        <td>{$date}</td>
                                        <td>{$forecast[1]}</td>
                                        <td>{$forecast[2]}</td>
                                        <td>{$temp}</td>
                                        <td>{$rain}</td>
                                    </tr>
                                ";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- About Section -->
    <!--<section id="geolocate" class="about-section">
        <div class="container">
            <div class="map-wrapper">
                <div class="map">
                    <div id="map" class="map-inner" style="width:100%;height:500px;"></div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <h1>Scrolling Nav</h1>
                    <p><strong>Usage Instructions:</strong> Make sure to include the <code>scrolling-nav.js</code>, <code>jquery.easing.min.js</code>, and <code>scrolling-nav.css</code> files. To make a link smooth scroll to another section on the page, give the link the <code>.page-scroll</code> class and set the link target to a corresponding ID on the page.</p>
                    <a class="btn btn-default page-scroll" href="#about">Click Me to Scroll Down!</a>
                </div>
            </div>
        </div>
    </section>-->

    <!-- jQuery -->
    <script src="../../../../html/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../../../html/js/bootstrap.min.js"></script>

    <script src="../../../../html/js/jquery.dataTables.min.js"></script>
    <script src="../../../../html/js/dataTables.responsive.min.js"></script>
    <script src="../../../../html/js/dataTables.bootstrap.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="../../../../html/js/jquery.easing.min.js"></script>
    <script src="../../../../html/js/scrolling-nav.js"></script>

    <!-- google maps  -->
    <script src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true"></script>
    <script src="../../../../html/js/gmap3.min.js"></script>
    <script src="../../../../html/js/gmap3.infobox.min.js"></script>

    <script src="../../../../html/js/black-river.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sales-forecasts').DataTable({"pageLength": 50});
        });         
    </script>

</body>

</html>
