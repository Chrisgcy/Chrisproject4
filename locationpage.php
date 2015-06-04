<?php
    session_start();

    $_SESSION['thispage'] = "location";

    if($_SESSION['uname'] == null) {
        header("location:logout.php");
    }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">	
    
    <!-- Bootstrap core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <style>
        body {
            padding-top: 100px;
        }
        .btn {
            margin-top: 10px;
        }
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
    </style>

    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script>
    function initialize() {
<?php
    include("db_connect.inc.php");
    $sql = sprintf("SELECT * FROM Location WHERE lid='%s'", $_GET["lid"]);
    $result = mysql_query($sql);

    if ($result) {
        $loc = mysql_fetch_assoc($result);
        echo sprintf("var myLat = %f;\n", $loc["latitude"]);
        echo sprintf("var myLon = %f;\n", $loc["longitude"]);
        echo sprintf("var myLocName = \"%s\";\n", $loc["lname"]);
        $myLocName = $loc["lname"];
        mysql_free_result($result);
    } else {
        error_log("location page:".$sql);
        error_log(mysql_error());    
        echo "var myLat = 0;\n";
        echo "var myLon = 0;\n";
        echo "var myLonName = 'Cannot find location in our website...';\n";
        $myLocName = "Cannot find location in our website...";
    }
    mysql_close($connect);
    
?>
        var myLatlng = new google.maps.LatLng(myLon, myLat);
        var mapOptions = {
            zoom: 6,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    
        var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        map: map,
                                        title: 'Hello World!'
                                        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>

    <title>Wildbook</title>
</head>
<body>
    <?php
        include("header.inc.php");
    ?>
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        
        <section>
        <h1><?php echo $myLocName ?></h1>
        </section>
        <section>
            <div style="width:100%; height:360px; margin:0 0 30px 0;">
                <div id="map-canvas"></div>
            </div>
        </section>
        <section>
            <span><p>Things happening at <?php echo $myLocName ?>:</p></span>
        </section>
        <section>
            <?php
                include("fetchlocationpost.inc.php");
            ?>
        </section>
    </div>
        </div>
    </div>

</body>
</html>
