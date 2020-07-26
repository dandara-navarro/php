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
        $results = fwrite($fp, $product_id.'|'.$user_email.'|'.$data['title'].'|'.$data['price'].'|'.$data['description'].'|'.$product_picture.'|'.'false'.PHP_EOL);

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
    $card_head = '<div class="col-md-3">';

    if(!isset($_SESSION['email']))
    {
        $card_head .= '<div class="panel panel-info">
                            <div class="panel-heading">';
    }
    else
    {
        if($pinStatus == 'true')
        {
            $card_head .= '<div class="panel panel-warning">
                            <div class="panel-heading">
                                <a class="pin-button" data-toggle="tooltip" title="Unpin item">
                                    <i class="fa fa-dot-circle-o"></i>
                                </a>';
        }
        else
        {
            $card_head .= '<div class="panel panel-info">
                            <div class="panel-heading">
                                <a class="pin-button" data-toggle="tooltip" title="Pin item">
                                    <i class="fa fa-thumb-tack"></i>
                                </a>';
        }
    }
    return $card_head;
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

            if($pieces[0] == $id)
            {
                $product = $pieces;          
            }
        }
    }
    return $product;
}

function downvoteProduct($product_id, $user_email)
{   
    if(userCanDownvote($product_id, $user_email))
    {
        $lines = file('downvotes.txt');

        $fp = fopen('downvotes.txt', 'a+');

        if($fp != false)
        {
            $results = fwrite($fp, $product_id.'|'.$user_email. PHP_EOL);

            fclose($fp);
        }
    }
    else
    {
        setcookie('error_message', 'You already downvote this item', time() + 60);
    }

    $product_downvotes = countDownVotes($product_id);

    if($product_downvotes == 5)
    {
        $fp2 = fopen('archive_products.txt', 'a+');
        if($fp2 != false)
        {
            $results = fwrite($fp2, $product_id.'|');
            fclose($fp2);
            setcookie('error_message', 'The item was excluded because it has 5 down votes', time() + 60);
        }
    }
 
}

/* Function to check if the user already downvote this product or
if the user can still do this */
function userCanDownvote($product_id, $user_email)
{
   $result = true;
   
   $lines = file('downvotes.txt');
    
   if($lines != false)
   {
       foreach($lines as $line)
       {
           $pieces = preg_split("/\|/", $line);

           if($pieces[0] == $product_id && trim($pieces[1]) == $user_email)
           {
                $result = false;         
           }
       }
   }
   return $result; 
}

/* Function to return how many down votes a product has */
function countDownVotes($product_id)
{
    $count = 0;

    $lines = file('downvotes.txt');
    
    if($lines != false)
    {
       foreach($lines as $line)
       {
            $pieces = preg_split("/\|/", $line);

            if($pieces[0] == $product_id)
            {
               $count++; 
            }
       }
   }

   return $count;
}

function productIsArchived($product_id)
{
    $archived_products = file_get_contents("archive_products.txt");
    
    return strpos($archived_products, $product_id);
}

/* Function to assemble the template for the Recent viewed list and Sale list */
function renderProducts($file, $type, $is_searching)
{
    $products_list = '';
    
    $viewed_list = false;

    $lines = file($file);

    foreach($lines as $line)
    {
        /* If the Recently viewed list is going to be assembled,
        we need to get the product by using its id, which is stored
        in the recent_viewed.txt file */ 
        if($type === 'viewed_list')
        {
            $pieces = getProduct(trim($line));
        }
        else
        {
            $pieces = preg_split("/\|/", $line);
        }
        
        $product_id = $pieces[0];

        /* Case the product is archived, case it has 5 downvotes, case it has been
        posted more than one hour, it will not be rendered */
        if(productIsArchived($product_id) === false)
        {
            if($type === 'viewed_list')
            {
                $viewed_list = true;
                $products_list .= '
                    <div class="col-md-3">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                   '.$pieces[2];
                                             
            }
            else
            {
                $product_pinned = trim($pieces[6]);
                $products_list .= getCardStyle($product_pinned, $product_id);
                $products_list .= '<span>
                                    '.$pieces[2].'
                                    </span>
                                ';
            }
    
            $owner_email = $pieces[1];
            $product_price = $pieces[3];
            $product_image = $pieces[5];
    
            if(isset($_SESSION['email']) && isTheOwner($_SESSION['email'], $owner_email) && !$viewed_list)
            {
                $products_list .= '
                    <span class="pull-right">
                        <a class="" href="delete.php?id='.$product_id.'" data-toggle="tooltip" title="Delete item">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                    ';
            }
                
            $products_list .= '
                </div>
                <div class="panel-body text-center">
                    <p>
                        <a href="product.php?id='.$product_id.'">
                            <img class="img-rounded img-thumbnail" src="products/'.$product_image.'"/>
                        </a>
                    </p>
                    <p class="text-muted text-justify">
                        '.$pieces[4].'
                    </p>';
            // only shows the downvote button if the user is logged in
            if(isset($_SESSION['loggedin']))
            {
                $products_list .= '
                <a class="pull-left" href="redirect.php?downvote='.$product_id.'" data-toggle="tooltip" title="Downvote item">
                    <i class="fa fa-thumbs-down"></i>
                </a>';
            }    
                    
            $products_list .= '</div>
                                <div class="panel-footer ">
                                    <span><a href="mailto:'.$owner_email.'" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> '.getUser($owner_email).'</a></span>
                                    <span class="pull-right">'.$product_price.'</span>
                                    </div>
                                </div>
                            </div>';
        }
    }   

    return $products_list;

}

?>