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

?>