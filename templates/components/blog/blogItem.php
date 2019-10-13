<div class="_item recipe-item realtive">
    <div class="_head">
        <?php 
        if(isset($_SESSION['rol']) && $_SESSION['rol']==MODERADOR){
		?>
        <div class="<?php echo ($blog->getDestacado()==1)?"star":'other'?> abs-right-0 abs-top-0"
            target_identify="<?php echo $blog->getId_blog() ?>">
            <a href="#!" onclick="blogDestacado(<?php echo $blog->getId_blog() ?>)"
                class="txt-white flex-center flex-y">
                <span class="hidden"><?php  echo $blog->getDestacado()?></span>
                <img src="<?php echo IMAGES?>icons/star-solid.svg" alt="destacado" width="30" height="30">
                <span class="<?php echo ($blog->getDestacado()==1)?"txt-black":'txt-white'?>">Destacado</span>
            </a>
        </div>
        <?php
		}else{
		    if($blog->getDestacado()==1){?>
        <div class="star abs-right-0 abs-top-0">
            <a href="#!" class="txt-white flex-center flex-y">
                <img src="<?php echo IMAGES?>icons/star-solid.svg" alt="destacado" width="30" height="30">
                <span class="<?php echo ($blog->getDestacado()==1)?"txt-black":'txt-white'?>">Destacado</span>
            </a>
        </div>
        <?php
			}
											
		}?>
    </div>
    <div class="_body font-i-f">
        <?php  echo '<img src="'.$blog->getRecipe()->getUrl_image().'">';?>
        <?php  echo '<h4 class="tittle txt-center" style="font-size:1.3em">'. $blog->getRecipe()->getName_recipe().'</h4>';?>
        <?php if(isset($_SESSION['ID_USER'])){?>
            <div class="like-container relative" style="bottom:20px">
                <?php include COMPONENTS."buttons/like.php"?>
            </div>
        <?php }?>
    </div>
    <div class="_footer font-i-f">
        <div class="user flex-center flex-y" style="margin:10px 0;">
            <p>Usuario: <?php echo $blog->getUser()->getUsername(); ?></p>
            <p>
                <span><?php //echo $blog->getUser()->getName_user(); ?></span>
                <span><?php //echo $blog->getUser()->getLast_name(); ?></span>
            </p>
        </div>
        <?php if(!(empty($blog->getUrl_social_network()))){ ?>
        <div class="social-red flex-center flex-y hidden" data-social="social-link-<?php echo $blog->getId_blog()?>">
            <p class="txt-center" style="font-size:1.3em">Redes sociales</p>
            <ul class="l-s-none social-list">
                <?php 
					foreach($blog->getUrl_social_network() as $sn){
				?>
                <li class="item-social">
                    <a href="<?php echo $sn->link; ?>" target="_blank" class="<?php echo $sn->name_socialNetwork;?>">
                        <!-- <i class="<?php //echo $sn->name_class;?>"></i> -->
                        <img src="<?php echo IMAGES.'icons/socialNetwork/'.$sn->name_socialNetwork.'.svg';?>"
                            alt="<?php echo $sn->name_socialNetwork;?>" width="30" height="30">
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
        <?php }?>

        
        <div class="setting  abs-right-0 abs-bottom-0 flex">
            <?php include COMPONENTS."blog/groupButtons.php";	?>
        </div>
    </div>
</div>
<?php require_once COMPONENTS."blog/groupButtons.php"; ?>
