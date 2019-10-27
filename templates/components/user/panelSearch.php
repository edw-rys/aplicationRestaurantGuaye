<div class="generate-users flex flex-y">
<?php
if(!empty($data["users"])){
    foreach ($data["users"] as $user) {
?>
    <a href="<?php echo URL."user/profile/".$user->username ?>" class="flex box-user-min">
        <div class="picture">
            <img src="<?php 
            if(!empty($user->url_photo)){
                echo URL .$user->url_photo;
            }else{
                if($user->gender==1){
                    echo IMAGES.'pictures/upload/default/male.png';
                }else{
                    echo IMAGES.'pictures/upload/default/female.png';
                }
            } 
            ?>" alt="">
        </div>
        <div class="data">
            <p>
                <span><?php echo $user->username?></span>
            </p>
            <p>
                <span><?php echo $user->name_user?></span>
                <span><?php echo $user->last_name?></span>
            </p>
        </div>
    </a>
<?php
    }
}
?>
</div>