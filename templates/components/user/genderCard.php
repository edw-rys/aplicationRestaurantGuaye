<div class="container-gender-input <?php echo isset($gender)?$gender:''?> relative  txt-white"  label-field='gendernameClasslabel' style="z-index:200">
    <label class="gender-label relative center">
        <input type="radio" name="gender" value="0" checked>
        <div class="capa">
            <img src="<?php echo IMAGES."icons/".$gender.".svg"?>" alt="">
            <span class="flex-center" label-field='gendertextlabel'><?php echo isset($name_gender)?$name_gender:''?></span>
        </div>
    </label>
</div>