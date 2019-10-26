<div class="app-nav">
    <div class="nav-header">
        <div class="app-icon">
            <img src="<?php
            if(!empty($data['user']->geturl_photo())){
                echo URL .$data['user']->geturl_photo();
            }else{
                if($data['user']->getid_gender()==1){
                    echo IMAGES.'pictures/upload/default/male.png';
                }else{
                    echo IMAGES.'pictures/upload/default/female.png';
                }
            }  ?>" label-field='urlPhotolabel' alt="">
        </div>
    </div>
    <div class="nav-items">
        <div class="nav-item flex-center txt-white">
            <p label-field='usernamelabel'><?php echo $data['user']->getUsername()?></p>
        </div>
        <div class="nav-item flex-center txt-white">
            <p label-field='namelastnamelabel'><?php echo $data['user']->getName_user().' '.$data['user']->getLast_name() ?></p>
        </div>
        <div class="nav-item flex-center txt-white">
            <a class="block" href="#!" onclick="configView()">
                <span>Editar</span>
                <i class="far fa-edit"></i>
            </a>
        </div>
        <?php 
            if($data['user']->getid_gender()==1){
                $gender = "male";
            }else{
                $gender = "female";
            }
            $name_gender = $data['user']->getname_gender();
            include_once COMPONENTS.'user/genderCard.php';
        ?>
    </div>
    <div class="nav-bottom"></div>
</div>