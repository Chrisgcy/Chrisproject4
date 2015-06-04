<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="navbar-header">
                    <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>-->
                    <a class="navbar-brand" href="#">Wildbook</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
<?php
    if($_SESSION['thispage'] == "wall") {
        echo "<li class='active'><a href='#'>My Wall</a></li>";
    } else {
        echo "<li><a href='wall.php'>My Wall</a></li>";
    }
    if($_SESSION['thispage'] == "profile") {
        echo "<li class='active'><a href='#'>Profile</a></li>";
    } else {
        echo "<li><a href='profile.php'>Profile</a></li>";
    }
    if($_SESSION['thispage'] == "newsfeed") {
        echo "<li class='active'><a href='#'>News Feed</a></li>";
    } else {
        echo "<li><a href='newsfeed.php'>News Feed</a></li>";
    }
?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>

            <!--  Search Bar  -->
            <div class="col-md-4">
                <form action="searchpost.php" method="POST">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="keyword" style="margin-top: 10px;">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="col-md-1 pull-right">
                <ul class="nav navbar-nav">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
