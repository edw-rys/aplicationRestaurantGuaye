<?php include_once NAVIGATION?>
<div style="margin-top:53px"></div>
<div class="stage">
    <div class="app">
        <div class="app-content">
            <?php include_once COMPONENTS."user/navHeader.php";?>
            <div class="app-view">
                <div class="posts" id="post-blog-user">
                <?php for ($i=0; $i < 20; $i++) { 
                    include COMPONENTS . "blog/post_min.php";
                }?>  
                </div>
            </div>
        </div>
    </div>
</div>