<div class="group-buttons-blog">
    <div class="demo">
      <div class="demo__buttons">

        <?php 
        if(isset($_SESSION['ID_USER'])){
           if($blog->getUser()->getId_user()==$_SESSION['ID_USER'] || $_SESSION['rol']==MODERADOR){
        ?>
            <div class="demo__social-btn-4 demo__social-btn btn-remove"
                onclick="deletePost(<?php echo $blog->getId_blog()?>,this)">
                <i class="far fa-trash-alt"></i>
            </div>
        <?php }
            if($blog->getUser()->getId_user()==$_SESSION['ID_USER']){
        ?>
            <div class="demo__social-btn-3 demo__social-btn btn-edit"
                onclick="editPost(<?php echo $blog->getId_blog()?>) ">
                <i class="far fa-edit"></i>
            </div>
        <?php }}?>

        

        <div class="demo__social-btn-2 demo__social-btn btn-social-network"
            onclick="toggle(`[data-social='social-link-<?php echo $blog->getId_blog()?>']`,'hidden')">
            <i class="fas fa-users"></i>
        </div>
        <div class="demo__social-btn-1 demo__social-btn btn-view"
            onclick="viewBlog(<?php echo $blog->getId_blog()?>)">
            <i class="far fa-eye"></i>
        </div>
        <div class="demo__open-btn" onclick="activeOptionsBlogBtn(this)">
            <i class="fas fa-ellipsis-v"></i>
        </div>
      </div>
    </div>
</div>