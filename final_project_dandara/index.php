<?php 
session_start();

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

$message = '';
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
            <?php if(isset($_SESSION['user']))
            {
                echo '<p class="pull-right">User:' . $_SESSION['user'] . '</p>';
            }?>
            <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-default" data-toggle="modal" data-target="#newItem"><i class="fa fa-photo"></i> New Item</button>
                <?php if(isset($_SESSION['user']))
                {
                    echo '<a href="logout.php" class="btn btn-default pull-right"><i class="fa fa-sign-out"> </i> Logout</a>';
                }
                ?>
                <?php if(!isset($_SESSION['user']))
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
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                            Noodles
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/f88008dc63a67983e5824dafa0935662.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et accumsan mauris, non faucibus massa. Maecenas ac dolor aliquet, euismod nisl ut, congue quam.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Alex Akins</a></span>
                        <span class="pull-right">$11.99</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Apple
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/1f3870be274f6c49b3e31a0c6728957f.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Vivamus quam dolor, ultricies sed gravida vitae, dictum eu lectus. Cras suscipit urna leo, eget luctus nisi luctus vel. Suspendisse in pulvinar libero.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Alex Akins</a></span>
                        <span class="pull-right">$1.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Sushi
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/aea6de9cbaee9d2704dcf81f4a194991.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Donec aliquet vulputate neque nec posuere. Fusce a ex elementum, aliquam lectus vel, tincidunt sem. Sed pharetra imperdiet mauris ut semper.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Jane Smith</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Cherry
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                               <img class="img-rounded img-thumbnail" src="products/c7a4476fc64b75ead800da9ea2b7d072.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Pellentesque a convallis velit, et viverra odio. Phasellus maximus erat eu finibus tristique. Aliquam posuere, metus ac eleifend dignissim.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Jane Smith</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>


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

            <div class="col-md-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Unpin item">
                            <i class="fa fa-dot-circle-o"></i>
                        </a>
                        <span>
                            Noodles
                        </span>
                        <span class="pull-right">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/f88008dc63a67983e5824dafa0935662.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et accumsan mauris, non faucibus massa. Maecenas ac dolor aliquet, euismod nisl ut, congue quam.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Alex Akins</a></span>
                        <span class="pull-right">$11.99</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Unpin item">
                            <i class="fa fa-dot-circle-o"></i>
                        </a>
                        <span>
                            Cherry
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/c7a4476fc64b75ead800da9ea2b7d072.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Pellentesque a convallis velit, et viverra odio. Phasellus maximus erat eu finibus tristique. Aliquam posuere, metus ac eleifend dignissim.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Jane Smith</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Sushi
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/aea6de9cbaee9d2704dcf81f4a194991.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Donec aliquet vulputate neque nec posuere. Fusce a ex elementum, aliquam lectus vel, tincidunt sem. Sed pharetra imperdiet mauris ut semper.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Jane Smith</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Apple
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/1f3870be274f6c49b3e31a0c6728957f.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Vivamus quam dolor, ultricies sed gravida vitae, dictum eu lectus. Cras suscipit urna leo, eget luctus nisi luctus vel. Suspendisse in pulvinar libero.
                        </p>
                        <a class="pull-left" href="">
                            <i class="fa fa-thumbs-down" data-toggle="tooltip" title="Downvote item"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Zebra Zaney</a></span>
                        <span class="pull-right">$1.00</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Noodles
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/f88008dc63a67983e5824dafa0935662.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et accumsan mauris, non faucibus massa. Maecenas ac dolor aliquet, euismod nisl ut, congue quam.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Zebra Zaney</a></span>
                        <span class="pull-right">$11.99</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Apple
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/1f3870be274f6c49b3e31a0c6728957f.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Vivamus quam dolor, ultricies sed gravida vitae, dictum eu lectus. Cras suscipit urna leo, eget luctus nisi luctus vel. Suspendisse in pulvinar libero.
                        </p>
                        <a class="pull-left" href="">
                            <i class="fa fa-thumbs-down" data-toggle="tooltip" title="Downvote item"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> Zebra Zaney</a></span>
                        <span class="pull-right">$1.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Sushi
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/aea6de9cbaee9d2704dcf81f4a194991.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Donec aliquet vulputate neque nec posuere. Fusce a ex elementum, aliquam lectus vel, tincidunt sem. Sed pharetra imperdiet mauris ut semper.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> John Doe</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Cherry
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/c7a4476fc64b75ead800da9ea2b7d072.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Pellentesque a convallis velit, et viverra odio. Phasellus maximus erat eu finibus tristique. Aliquam posuere, metus ac eleifend dignissim.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> John Doe</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a class="" href="" data-toggle="tooltip" title="Pin item">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                        <span>
                            Cherry
                        </span>
                        <span class="pull-right text-muted">
                            <a class="" href="" data-toggle="tooltip" title="Delete item">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>
                    <div class="panel-body text-center">
                        <p>
                            <a href="product.php">
                                <img class="img-rounded img-thumbnail" src="products/c7a4476fc64b75ead800da9ea2b7d072.png"/>
                            </a>
                        </p>
                        <p class="text-muted text-justify">
                            Pellentesque a convallis velit, et viverra odio. Phasellus maximus erat eu finibus tristique. Aliquam posuere, metus ac eleifend dignissim.
                        </p>
                        <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </div>
                    <div class="panel-footer ">
                        <span><a href="mailto:fakeemail@example.com" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> John Doe</a></span>
                        <span class="pull-right">$10.00</span>
                    </div>
                </div>
            </div>
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
    <form role="form" method="post" action="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">New Item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Picture</label>
                    <input class="form-control" type="file">
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
</html>
