	

	<?php 
	// 
		if(isset($_SESSION['USER'])){
		if(isset($_SESSION['rol']) && $_SESSION['rol']==101){
	?>		

	<div class="container">
		<div class="form">
			<div class="flex-center">
				<h2 class="txt-center tittle-sty-bck bck-t-first">Agregar menú</h2>
			</div>
			<div class="form-send">

				<form class="menudiario" action="index.php?c=dailymenu&a=save" method="POST" onsubmit=" return validarMenu()">
					<div class="radio">
						<span class="flex-center">Horario</span>
						<div class="op">
							<?php
							if(isset($schedules) && !empty($schedules)){
								foreach($schedules as $sc){
							?>
								<label class="radio-morning inactive">
								<?php echo $sc->getName_schedule()?>  
								<input type="radio" name="horario" value="<?php echo $sc->getId_schedule()?>" 
									<?php if(isset($editFood) && !empty($editFood)){if($editFood->id_schedule==$sc->getId_schedule()) echo 'checked';}?>/>
								</label>
							<?php
								}
							}
							?>
						</div>
						
					</div>
					<?php if(isset($editFood) && !empty($editFood)){?>
						<input type="hidden" name="idc" value="<?php echo isset($editFood)?$editFood->id_control:''?>">
						<input type="hidden" name="idf" value="<?php echo isset($editFood)?$editFood->id_food:''?>">
					<?php } ?>
					<div class="select">
						<span class="txt-center">Tipo</span>
						<select name="type_food">
							<option value="0">Seleccione ..</option>
							<?php
								
								if(isset($typesFood) && !empty($typesFood)){
									foreach($typesFood as $type){
									?>
									<option value="<?php echo $type->getId_TypeFood();?>"
										<?php if(isset($editFood) && !empty($editFood)){if($editFood->id_TypeFood==$type->getId_TypeFood()) echo 'selected';}?>>
										<?php echo $type->getName_TypeFood();?>
									</option>
									<?php
									}
								}
							?>
						</select>
					</div>

					<div class="line">
							<label><span>Nombre</span>
								<input class="input-txt" type="text" name="nombre" value="<?php echo isset($editFood)?$editFood->name_food:''?>">
							</label>
							<label><span>Precio</span>
								<input class="input-txt" type="text" name="precio" value="<?php echo isset($editFood)?$editFood->price:'1'?>" min="0" >
							</label>
					</div>
					<div class="area">
						<label>Breve descripción </label>
						<textarea name="descripcion"><?php echo isset($editFood)?$editFood->description_food:''?></textarea>
					</div>
					<div class="select">
						<label>Categoría</label>
							<select name="ctg">
								<option value="0">Seleccione ..</option>
								<?php
								
								if(isset($ctgFood) && !empty($ctgFood)){
									foreach($ctgFood as $ctg){
									?>
									<option value="<?php echo $ctg->getId_ctgfood();?>"
									<?php if(isset($editFood) && !empty($editFood)){if($editFood->id_ctgfood==$ctg->getId_ctgfood()) echo 'selected';}?>>
										<?php echo $ctg->getName_ctgfood();?>
									</option>
									<?php
									}
								}
							?>
							</select>
					</div>
					<div class="buttons" style="display: grid;grid-template-columns: 1fr 1fr;">
						<input class="button btn-first" type="submit" name="submit" value="Agregar">
						<input class="button btn-first" type="reset" name="reset" value="Limpiar">
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php 
		}}
	?>	
