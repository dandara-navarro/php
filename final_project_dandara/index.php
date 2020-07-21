<?php 
require 'includes/manage_user.php';
require 'includes/manage_product.php';

session_start();

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

$message = '';
$user_logged = isset($_SESSION['user']);

if(isset($_COOKIE['error_message']))
{
    $message = '<div class="alert alert-danger text-center">'
        . $_COOKIE['error_message'] .
        '</div>';

    setcookie('error_message', null, time() - 3600);
}

if(isset($_GET['from']))
{
    if($_GET['from'] === 'signup')
    {
        $message = '<div class="alert alert-success text-center">Thank you for signing up '
            . $_SESSION['user'] .
            '</div>';
    }
    elseif($_GET['from'] === 'login')
    {
        $message = '<div class="alert alert-success text-center">Thank you for logging in '
            . $_SESSION['user'] .
            '</div>';
    }
}
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
                <?php echo $message; ?>
            </div>
        </div>

        <div class="row">
            <?php if($user_logged)
            {
                echo '<p class="pull-right">User:' . $_SESSION['user'] . '</p>';
            }?>
            <div class="col-md-6 col-md-offset-3">
                <?php if($user_logged)
                {
                    echo '<button class="btn btn-default" data-toggle="modal" data-target="#newItem"><i class="fa fa-photo"></i> New Item</button>
                    <a href="logout.php" class="btn btn-default pull-right"><i class="fa fa-sign-out"> </i> Logout</a>';
                }
                ?>
                <?php if(!$user_logged)
                {
                    echo '<a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"> </i> Login</a>
                    <a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#signup"><i class="fa fa-user"> </i> Sign Up</a>';
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Recently Viewed
                </h2>
                <hr/>
            </div>
        </div>
        <div class="row">
        <?php renderProducts('recent_viewed.txt', 'viewed_list') ?>
        </div>

        <div class="row">
            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Items For Sale
                </h2>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                    <form class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                <input type="text" class="form-control" placeholder="Search"/>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-default" value="Search"/>
                        <button class="btn btn-default" data-toggle="tooltip" title="Shareable Link!"><i class="fa fa-share"></i></button>
                    </form>
                <br/>
            </div>
        </div>

        <div class="row">
            <?php renderProducts('products.txt', 'sale_list') ?>
        </div>
    </div>
</div>

<div id="login" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form role="form" method="post" action="redirect.php?from=login">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Login</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" class="form-control" type="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Login!"/>
            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="newItem" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form role="form" method="post" action="redirect.php?from=new-item" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">New Item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" class="form-control" type="text" maxlength="30" placeholder="Product Title">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input name="price" class="form-control" type="text" placeholder="Product Proce. E.g. 12.99">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input name="description" class="form-control" type="text" placeholder="Procuct Description">
                </div>
                <div class="form-group">
                    <label>Picture</label>
                    <input name="picture" class="form-control" type="file">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Post Item!"/>
            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="signup" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form role="form" method="post" action="redirect.php?from=signup">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Sign Up</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>First Name</label>
                    <input name="first-name" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input name="last-name" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input name="email" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input name="password" class="form-control" type="password">
                </div>
                <div class="form-group">
                    <label>Verify Password *</label>
                    <input name="verify-password" class="form-control" type="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Sign Up!"/>
            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script src="js/scripts.js"></script>
</html>
