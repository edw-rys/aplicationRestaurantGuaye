<div class="form-clasic" style="width:100%">
<div class="header_">
	<div class="bottom-head txt-center"><h2 class="title">Nueva receta</h2></div>
</div>
<form action="" onsubmit="return saveBlog()" method="POST"  enctype="multipart/form-data" id="formRecipe">
	<input type="hidden" name="id" value="<?php echo isset($blog_edit)?$blog_edit->getId_blog():''?>">
	<input type="hidden" name="id_recipe" value="<?php echo isset($blog_edit)?$blog_edit->getRecipe()->getId_recipe():''?>">
	<div class="">
		<div class="flex-center">
			<span class="container-input border-botom" style="--color:var(--color-third)">
				<input class="balloon" id="name" type="text" name="nombre" placeholder="Escriba el título de la receta" value="<?php echo isset($blog_edit)?$blog_edit->getRecipe()->getName_recipe():''?>"/>
				<label for="name">Título</label>
			</span>
		</div>
		<div class="conjunt">
			<div class="txt-area">
				<label for="preparacion">
					<span class="border-bottom-unique block">Preparación</span>
				</label>
				<div class="flex-y">
					<textarea class="border-bottom-unique no-outline" id="preparacion" name="preparacion" rows="5"><?php echo isset($blog_edit)?$blog_edit->getRecipe()->getPreparation():'';?></textarea>
				</div>
			</div>
			<div class="panel-inf-3col flex">
				<div class="separe flex-center">
					<div class="input-image-icon">
						<label class="image-select" for="image">
							<span class="icon">
								<i class="far fa-images"></i>
								<span>Foto</span>
							</span>
						</label>
						<?php 
						if(isset($blog_edit)){
							echo "<input type='hidden' name='imagen-edit' value ='".$blog_edit->getRecipe()->getUrl_image()."'>";
						}
						?>
						<input class="file-img" id="image" type="file" name="imagen"  accept="file_extension|image/*">
						
					</div>
				</div>
				<div class="separe flex-center">
					<a href="#!" onclick="addElementBlog('list-ingredients')">
						<i class="fas fa-plus"></i>
						<span>Ingrediente</span>
					</a>
				</div>
				<div class="separe flex-center">
					<a href="#!" onclick="addSocialLiInput('list-social-input')">
						<i class="fas fa-plus"></i>
						<span>Red social</span>
					</a>
				</div>
			</div>	
		</div>
		<div class="separe-grid-2col">
			<div class="ingredients-list list-separate-30px">
				<p class="" style="margin:5px;">
					<a href="#!" class="flex space-around" onclick="togglePanel('#list-ingredients')">
						<span>Ingredientes</span>
						<span class="block">
							<i class="fas fa-angle-down"></i>
						</span>
					</a>
				</p>
				<ul id="list-ingredients" class="flex-y">
					<?php if(isset($blog_edit)){
							foreach($blog_edit->getRecipe()->getIngredients() as $ingredient){?>
								<li class="flex space-around">
									<input class="input-txt border-bottom-unique no-outline" type="text" name="ingrediente[]" value="<?php echo $ingredient->name_ingredient?>">
									<input type="hidden" name="id_ingredient[]" value="<?php echo $ingredient->id_ingredient?>">
									<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
								</li>
					<?php 
							}
						}else{?>
		
					<li class="flex space-around">
						<input class="input-txt border-bottom-unique no-outline" type="text" name="ingrediente[]">
						<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
					</li>
					<li class="flex space-around">
						<input class="input-txt border-bottom-unique no-outline" type="text" name="ingrediente[]">
						<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="list-socialnetwork list-separate-30px">
				<p class="" style="margin:3px;">
					<a href="#!" class="flex space-around" onclick="togglePanel('#list-social-input')">
						<span>Sus redes</span>
						<span class="block">
							<i class="fas fa-angle-down"></i>
						</span>
					</a>
				</p>
				<ul id="list-social-input" class="flex-y flex-center">
					<?php if(isset($blog_edit)){
							foreach($blog_edit->getUrl_social_network() as $sn){?>
								<li class="space-around flex">
									<input class="input-txt border-bottom-unique" type="text" name="input-social[]" value="<?php echo $sn->link?>">
									<select name="social-op[]" id="">
										<option value="0">Seleccione ..</option>
										<?php foreach($data["socialNetworkList"] as $snlist){?>
											<option value="<?php echo $snlist->id_socialNetwork ?>" 
											<?php if($snlist->id_socialNetwork == $sn->id_socialNetwork){
												echo "selected";
											} ?> >
												<?php echo $snlist->name_socialNetwork?>
											</option>
										<?php } ?>
										<?php?>
									</select>
									<input type="hidden" name="id-link-sn[]" value="<?php echo $sn->id_link?>">
									<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
								</li>
					<?php 
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>

	<div class="send flex-center">
		<button class="button btn-first c-pinter" type="submit" name="save" style="width: 60%;">Publicar</button>
	</div>
</form>
</div>