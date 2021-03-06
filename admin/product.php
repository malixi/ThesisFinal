<?php
session_start();
require_once 'class.user.php';
require_once 'connector.php';
$user_home = new USER();

if(!$user_home->is_logged_in()){
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM admin WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['dosearch'])){
    $query=$_GET['doseach'];
    echo $query;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GRAY ENTERPRISE</title>



    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>




<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php">GRAY ENTERPRISE</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="../index.php"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $row['userEmail']; ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="usersettings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="viewproductpage.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Products</a>
                    </li>
                    <li>
                        <a href="viewadminpage.php"><i class="fa fa-dashboard fa-fw"></i> Admins</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <?php
                $prodID=$_POST['PNAME'];
                $results = mysqli_query ($dbconn ,"SELECT * FROM products WHERE productID = '". $prodID . "'");
                if($results->num_rows > 0) {
                    while($row = mysqli_fetch_array($results)){
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $row['name']; ?></h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <div class="row">
                <div class="col-lg-6">
                    <?php
                        if($row['image'] == "Submit"){
                            echo '<img src="productimage/logo.png" data-imagezoom="true" class="img-responsive" width="50%"> </div>';
                         }else{
                           echo '<img src="productimage/'.$row['image'].'" data-imagezoom="true" class="img-responsive" width="50%"> </div>';
                         }
                    ?>
                </div>
                <div class="col-lg-6">
                    <?php
                        echo '<table class="table table-hover">';
                        echo '
                            <tbody>
                                </tr>
                                    <td>Product ID</td>
                                    <td>'.$row['productID'].'</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>'.$row['description'].'</td>
                                </tr>
                                <tr>
                                    <td>Date Created</td>
                                    <td>'.$row['date_created'].'</td>
                                <tr>
                                </tr>
                                    <td>Price</td>
                                    <td>'.$row['price'].'</td>
                                </tr>
                                </tr>
                                    <td>Quantity</td>
                                    <td>'.$row['quantity'].'</td>
                                </tr>
                                <td>
                                    <div>
                                        <form style="margin-bottom: 0em;" method="POST" action="editproductpage.php">
                                            <input type="hidden" name="PNAME" value='.$row['productID'].' />
                                            <input type="submit" class="btn btn-warning" value="Edit" name="submit">
                                        </form>
                                    </div>
                                    <div>
                                        <form style="margin-bottom: 0em;" method="POST" action="delproductprocess.php">
                                            <input type="hidden" name="PNAME" value='.$row['productID'].' />
                                            <input type="submit" class="btn btn-danger" value="Delete" name="submit" Onclick=\"return ConfirmDelete()\">
                                        </form>
                                    </div>
                                    <div>
                                            <form style="margin-bottom: 0em;" method="POST" action="product.php">
                                                    <input type="hidden" name="PNAME" value='.$row['productID'].' />
                                                    <input type="submit" class="btn btn-primary" value="View" name="submit">
                                            </form>
                                    </div>
                                </td>
                            </tbody>';
                        echo '</table>';
                    ?>
                </div>
            </div>
            <!-- ... Your content ends here ... -->
            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

</body>
</html>
