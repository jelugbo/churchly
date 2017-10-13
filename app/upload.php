<?php

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
$path = 'upload/'; // upload directory

if(isset($_FILES['file']))
{
    $img = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    // can upload same image using rand function
    $final_image = rand(1000,1000000).$img;

    // check's valid format
    if(in_array($ext, $valid_extensions))
    {
        $path = $path.strtolower($final_image);

        if(move_uploaded_file($tmp,$path))
        {
            echo "<img class='img-circle' alt='parish-logo' src='$path' />";
        }
    }
    else
    {
        echo 'invalid file';
    }
}

?>