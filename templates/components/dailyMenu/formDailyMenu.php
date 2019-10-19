<?php if(isset($data["food"])){ $editFood=$data["food"];}?>
<div class="form-clasic">
    <div class="header_">
		<div class="bottom-head txt-center">
			<!-- <h2 class="title">Nueva receta</h2> -->
			<h2 class="txt-center tittle-sty-bck bck-t-first">Agregar menú</h2>
		</div>
	</div>
	<form action="" id="formDailyMenu" onsubmit="return saveMenu()">
		<div class="middle flex-center">
			<?php
			if(isset($data["schedules"]) && !empty($data["schedules"])){
				foreach($data["schedules"] as $sc){
			?>
			<label class="txt-white">
				<input type="radio" name="horario" value="<?php echo $sc->getId_schedule()?>"
					<?php if(isset($editFood) && !empty($editFood)){if($editFood->id_schedule==$sc->getId_schedule()) echo 'checked';}?> />
				<div class="box-radio">
				<span class="icon">
					<i class="<?php echo $sc->getname_icon()?>"></i>
				</span>
				<span class="title-radio"><?php echo $sc->getName_schedule()?></span>
				</div>
			</label>
			<?php }}?>
		</div>
		
		<?php if(isset($editFood) && !empty($editFood)){?>
		<input type="hidden" name="idc" value="<?php echo isset($editFood)?$editFood->id_control:''?>">
		<input type="hidden" name="idf" value="<?php echo isset($editFood)?$editFood->id_food:''?>">
		<?php } ?>
		<div class="flex-center">
			<span class="container-input border-botom">
				<input class="clean-slide" name="nombre" id="nombre" type="text" value="<?php echo isset($editFood)?$editFood->name_food:''?>"
					placeholder="Escriba el nombre de la comida" />
				<label for="nombre">Nombre</label>
			</span>
		</div>
		<div class="flex-center">
			<span class="container-input border-botom">
				<input class="clean-slide txt-right" name="precio" id="precio" type="text" value="<?php echo isset($editFood)?$editFood->price:'1'?>" min="0"
				placeholder="Digite el precio" />
				<label for="precio">Precio</label>
			</span>
		</div>
		<div class="flex-y flex-center m-10px">
			<span class="txt-center">Tipo</span>
			<div class="select-container">
				<select name="type_food" class="select border-bottom-unique">
					<option value="0">Seleccione ..</option>
					<?php if(isset($data["typesFood"]) && !empty($data["typesFood"])){
							foreach($data["typesFood"] as $type){?>
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
		</div>
		<div class="flex-center flex-y m-10px">
			<label>Categoría</label>
			<select name="ctg" class="select border-bottom-unique">
				<option value="0">Seleccione ..</option>
				<?php
				if(isset($data["ctgFood"]) && !empty($data["ctgFood"])){
					foreach($data["ctgFood"] as $ctg){ ?>
				<option value="<?php echo $ctg->getId_ctgfood();?>"
					<?php if(isset($editFood) && !empty($editFood)){if($editFood->id_ctgfood==$ctg->getId_ctgfood()) echo 'selected';}?>>
					<?php echo $ctg->getName_ctgfood();?>
				</option>
				<?php }} ?>
			</select>
		</div>
		<div class="area txt-center">
			<label for="descripcion">
				<span class="border-bottom-unique block">Descripcion</span>
			</label>
			<!-- <label class="txt-center border-bottom-unique">Breve descripción </label> -->
			<div class="flex-y">
				<textarea class="no-borde no-outline" id="descripcion" rows="4" name="descripcion"><?php echo isset($editFood)?$editFood->description_food:''?></textarea>
			</div>
		</div>
		<div class="buttons" style="display: grid;grid-template-columns: 1fr 1fr;">
			<button class="button btn-first" type="submit" name="submit">Agregar</button>
			<input class="button btn-first" type="reset" name="reset" value="Limpiar">
		</div>
		
	</form>
</div>