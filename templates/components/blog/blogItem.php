<div class="_item grid-center recipe-item relative item-blog-number-<?php echo isset($blog)?$blog->getId_blog():''; ?>" style="margin: 10px 0">
    <div class="_head">
    </div>
    <div class="_body font-i-f">
        <div class="_picture_recipe">
            <?php  echo '<img src="'.$blog->getRecipe()->getUrl_image().'" onclick="viewImage(\''.$blog->getRecipe()->getUrl_image().'\')">';?>
        </div>
        <?php  echo '<h4 class="tittle txt-center" style="font-size:1.3em">'. $blog->getRecipe()->getName_recipe().'</h4>';?>

        <div class="like-container relative" style="bottom:20px">
        <?php if(isset($_SESSION['ID_USER']) && $_SESSION['rol']==MODERADOR ){?>
                <?php 
                $status=$blog->getDestacado();
                    include COMPONENTS."buttons/like.php";
                ?>
        <?php }else{
            ?>
            <span class="abs-left"><i class="fas fa-star"style="font-size:25px;color:
            <?php echo $blog->getDestacado()?'#AEC100':'#818181';?>
                "></i>
            </span>
            <?php }?>
        </div>
    </div>
    <div class="_footer font-i-f">
        <div class="user flex-center flex-y" style="margin:10px 0;">
            <p>Usuario: <?php echo $blog->getUser()->getUsername(); ?></p>
            <p date-time="parent">
                <span class="hidden" date-time="date"><?php echo $blog->getcreation_date()?></span>
                <span date-time="blog"></span>                
            
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