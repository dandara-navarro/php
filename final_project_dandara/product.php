<?php 
require 'includes/manage_product.php';
require 'includes/manage_user.php';

$product_id = $_GET['id'];

$product = getProduct($product_id);

addRecentViewed($product_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>COMP 3015</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="wrapper">

    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1 class="login-panel text-center text-muted">
                    COMP 3015 Final Project
                </h1>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div>
                    <p>
                        <a class="btn btn-default" href="index.php">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </p>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <?php echo $product[2] ?> 
                    </div>
                    <div class="panel-body text-center">
                        <p>
                        <?php echo '
                            <img class="img-rounded img-thumbnail" src="products/'.$product[5].'"/>
                        ' ?> 
                        </p>
                        <p class="text-muted text-justify">
                        <?php echo $product[4] ?> 
                        </p>
                    </div>
                    <div class="panel-footer ">
                        <span><a href=""><i class="fa fa-envelope"></i> <?php echo getUser($product[1]) ?></a></span>
                        <span class="pull-right"><?php echo $product[3] ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
