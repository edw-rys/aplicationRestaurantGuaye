<div class="post <?php if(!isset($blogMin)){ echo 'loading';}else{echo 'item-blog-number-'.$blogMin->getId_blog();}?> ">
    <div class="post-vote">
        <div class="up flex-center btn-edit">
            <?php 
                if(isset($_SESSION["ID_USER"])){
                    if(isset($blogMin) && $blogMin->getUser()->getId_user()==$_SESSION["ID_USER"]){
                        ?>
                        <a href="#!" class="btn-op-post" onclick="editPost(<?php echo $blogMin->getId_blog()?>,'small')">
                            <i class="far fa-edit"></i>
                        </a>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="down flex-center btn-remove">
            <?php 
                if(isset($_SESSION["ID_USER"])){
                    if(isset($blogMin) && $blogMin->getUser()->getId_user()==$_SESSION["ID_USER"]){
                        ?>
                        <a href="#!" class="block btn-op-post" onclick="deletePost(<?php echo $blogMin->getId_blog()?>,this,'20px','20px')">
                            <i class="far fa-trash-alt"></i>
                        </a>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
    <div class="post-image">
        <?php if(isset($blogMin)){echo '<img src="'.URL.$blogMin->getRecipe()->getUrl_image().'">';} ?>
    </div>
    <div class="post-text">
    <div class="bar-post">
        <p>
            <?php if(isset($blogMin)){echo $blogMin->getRecipe()->getName_recipe();} ?>
        </p>
    </div>
    <div class="bar-post"></div>
    </div>
</div>