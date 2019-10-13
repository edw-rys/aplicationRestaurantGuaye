

<div class="">
	<div class="row" style="margin: auto;">
		<div id="form-blog" class="form-blog" style="margin: auto;">
			
			<form action="" onsubmit="return saveBlog()" method="POST"  enctype="multipart/form-data" id="formRecipe">
				<input type="hidden" name="id" value="<?php echo isset($blog_edit)?$blog_edit->getId_blog():''?>">
				<input type="hidden" name="id_recipe" value="<?php echo isset($blog_edit)?$blog_edit->getRecipe()->getId_recipe():''?>">
				<div class="_first_data flex space-around m-20">
					<label class="flex-y">
						<span>Nombre</span>
						<input class="input-txt" type="text" name="nombre" value="<?php echo isset($blog_edit)?$blog_edit->getRecipe()->getName_recipe():''?>">
					</label>
					<div class="image flex flex-center">
						<p style="margin:0 7px;">Selecione Imagen</p>
						<label class="image-select" for="">
							<span class="icon"><i class="far fa-images"></i></span>
							<input class="file-img" type="file" name="imagen"  accept="file_extension|image/*">
						</label>
					</div>
				</div>
				<div class="ingredientes flex-center flex-y m-20">
					<div class="flex">
						<span>Ingredientes</span>
					</div>

					<ul id="list-ingredients" class="flex-y">
						<?php if(isset($blog_edit)){
								foreach($blog_edit->getRecipe()->getIngredients() as $ingredient){?>
									<li class="flex space-around">
										<input class="input-txt" type="text" name="ingrediente[]" value="<?php echo $ingredient->name_ingredient?>">
										<input type="hidden" name="id_ingredient[]" value="<?php echo $ingredient->id_ingredient?>">
										<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
									</li>
						<?php 
								}
							}else{?>

						<li class="flex space-around">
							<input class="input-txt" type="text" name="ingrediente[]">
							<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
						</li>
						<li class="flex space-around">
							<input class="input-txt" type="text" name="ingrediente[]">
							<button type="button" onclick="removeCampFather(this)"><img src="assets/img/icons/trash-alt-regular.svg" width="20"></button>
						</li>
						<?php }?>
					</ul>
					<a href="#!" onclick="addElementBlog('list-ingredients')">Agregar otro  <img src="assets/img/icons/plus-solid.svg" width="15" /></a>
				</div>
				<label class="flex-y">
					<span>Preparación</span>
					<textarea name="preparacion" rows="5"><?php echo isset($blog_edit)?$blog_edit->getRecipe()->getPreparation():'';?></textarea>
				</label>
				<div class="social m-20">
					<div class="_add flex space-around">
						<p>¿Deseas añadir tus redes sociales?</p>
						<button type="button" onclick="addSocialLiInput('list-social-input')">Añadir</button>	
					</div>


					<ul id="list-social-input" class="flex-y flex-center">
						<?php if(isset($blog_edit)){
								foreach($blog_edit->getUrl_social_network() as $sn){?>
									<li class="space-around flex">
										<input class="input-txt" type="text" name="input-social[]" value="<?php echo $sn->link?>">
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
				<div class="send flex-center">
					<button class="button btn-first c-pinter" type="submit" name="save" style="width: 60%;">Publicar</button>

				</div>
			</form>
		</div>
	</div>
</div>