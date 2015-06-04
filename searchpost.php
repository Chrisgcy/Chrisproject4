<?php
    session_start();
    $_SESSION['thispage'] = "search";
    
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

    <!-- File Upload Generic page styles -->
    <link rel="stylesheet" href="https://rawgit.com/blueimp/jQuery-File-Upload/master/css/style.css">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="https://rawgit.com/blueimp/jQuery-File-Upload/master/css/jquery.fileupload.css">
    <link rel="stylesheet" href="https://rawgit.com/blueimp/jQuery-File-Upload/master/css/jquery.fileupload-ui.css">
                        

    <style>
        body {
            padding-top: 100px;
        }
        .btn {
            margin-top: 10px;
        }
    </style>

    <title>Wildbook</title>
</head>
<body>
    <?php
        include("header.inc.php");
    ?>
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <h1>Post related to <?php echo $_POST["keyword"] ?>:</h1>
        <section>
            <?php
                include("fetchkeyword.inc.php");
            ?>
        </section>
    </div>
        </div>
    </div>

</body>
</html>
