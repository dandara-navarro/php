<?php

function addProduct($user_email, $data, $file)
{
    $success = false;

    $product_picture = md5($user_email.time());

    $fp      = fopen('products.txt', 'a+');
    $moved   = move_uploaded_file($file['picture']['tmp_name'], 'products/'.$product_picture);

    if($fp != false && $moved)
    {
        $product_id = uniqid();
        $results = fwrite($fp, $product_id.'|'.$user_email.'|'.$data['title'].'|'.$data['price'].'|'.$data['description'].'|'.$product_picture.'|'.'unpin'.PHP_EOL);

        fclose($fp);

        if($results)
        {
            $success = true;
        }
    }

    return $success;
}

function addRecentViewed($id)
{
    $lines = file('recent_viewed.txt');
    
    //If has already 4 recent viewed, delete the last one and add another.
    if(count($lines) == 4)
    {
        array_pop($lines);
        file_put_contents('recent_viewed.txt', $lines);
    }
    
    $file_data = $id.PHP_EOL;
    $file_data .= file_get_contents('recent_viewed.txt');
    file_put_contents('recent_viewed.txt', $file_data);

}

function getProductsList()
{
    $lines = file('products.txt');
    $products = [];

    if($lines != false)
    {
        foreach($lines as $line)
        {
            $pieces = preg_split("/\|/", $line);

            $product['id']       = $pieces[0];
            $product['email'] = $pieces[1];
            $product['title']  = $pieces[2];
            $product['price']  = $pieces[3];
            $product['description']  = $pieces[4];
            $product['picture']  = $pieces[5];
            $product['pin']  = $pieces[6];

            $products[] = $product;
        }
    }

    return $products;
}

function getCardStyle($pinStatus, $item_id)
{
    if($pinStatus == 'true')
    {
        return '<div class="col-md-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <a class="pin-button" data-toggle="tooltip" title="Unpin item">
                            <i class="fa fa-dot-circle-o"></i>
                        </a>';
    }
    return '<div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a class="pin-button" data-toggle="tooltip" title="Pin item">
                        <i class="fa fa-thumb-tack"></i>
                    </a>';
    
}

function deleteProduct($id, $email)
{
    $lines = file('products.txt');

    if($lines != false)
    {
        // w truncates the file
        $fp = fopen('products.txt', 'w');

        // comb through all existing lines
        foreach($lines as $line)
        {
            $pieces = preg_split("/\|/", $line);

            // only deletes if the username matches
            if($pieces[0] == $id && $pieces[1] == $email)
            {
                unlink('products/'.trim($pieces[5])); // delete the file
                continue;                             // skip line, end loop
            }

            fwrite($fp, $line); // include this line
        }

        fclose($fp);
    }
}

function getProduct($id)
{
    $product = [];
    $lines = file('products.txt');
    
    if($lines != false)
    {
        foreach($lines as $line)
        {
            $pieces = preg_split("/\|/", $line);

            // only deletes if the username matches
            if($pieces[0] == $id)
            {
                $product = $pieces;          
            }
        }
    }
    return $product;
}

function renderProducts($file, $type)
{
    $viewed_list = false;
    $lines = file($file);

    foreach($lines as $line)
    {
        if($type === 'viewed_list')
        {
            $pieces = getProduct(trim($line));
            $viewed_list = true;
            echo '
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                               '.$pieces[2];
                                         
        }
        else
        {
            $pieces = preg_split("/\|/", $line);
            echo getCardStyle(trim($pieces[6]), $pieces[0]);
            echo '<span>
                   '.$pieces[2].'
                   </span>
               ';
        }
        
           if(isset($_SESSION['email']) && isTheOwner($_SESSION['email'], $pieces[1]))
           {
               echo '
               <span class="pull-right">
               <a class="" href="delete.php?id='.$pieces[0].'" data-toggle="tooltip" title="Delete item">
                   <i class="fa fa-trash"></i>
               </a>
           </span>
               ';
           }
                
       echo '
                
            </div>
            <div class="panel-body text-center">
                <p>
                    <a href="product.php?id='.$pieces[0].'">
                        <img class="img-rounded img-thumbnail" src="products/'.$pieces[5].'"/>
                    </a>
                </p>
                <p class="text-muted text-justify">
                    '.$pieces[4].'
                </p>
                <a class="pull-left" href="" data-toggle="tooltip" title="Downvote item">
                    <i class="fa fa-thumbs-down"></i>
                </a>
            </div>
            <div class="panel-footer ">
                <span><a href="mailto:'.$pieces[1].'" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> '.getUser($pieces[1]).'</a></span>
                <span class="pull-right">'.$pieces[3].'</span>
            </div>
        </div>
    </div>
        
        ';

    } 

}

?>