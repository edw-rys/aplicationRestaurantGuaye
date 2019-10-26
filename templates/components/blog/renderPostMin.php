<?php
if(isset($dataBlog) && !empty($dataBlog)){
    foreach ($dataBlog as $blogMin) {
        include COMPONENTS . "blog/post_min.php";
    }
}