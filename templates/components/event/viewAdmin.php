<?php
if(isset($data["events"])){
	foreach($data["events"] as $res){ ?>
	<div class="row-table" data-title="event-id-<?php echo $res->id_event?>">
			<div class="cell" data-title="Usuario"><?php echo $res->name_user; ?></div>
			<div class="cell" data-title="Fecha de creación"><?php echo $res->creation_date; ?></div>
			<div class="cell" data-title="Asunto"><?php echo $res->affair; ?></div>
			<div class="cell" data-title="Fecha de ejecución"><?php echo $res->execution_date; ?></div>
			<div class="cell" data-title="Hora de entrada"><?php echo $res->start_time; ?></div>
			<div class="cell" data-title="Hora de salida"><?php echo $res->end_time; ?></div>
			<div class="cell" data-title="Comentarios"><?php echo $res->comment; ?></div>

			<?php 
			if($res->is_accepted==1){
				?>
				<div class="cell" data-title="Aceptación">Aceptado</div>
				<?php
			}
			else{
				if(date("Y-m-d")>$res->execution_date){
				?>
					<div class="cell" data-title="Estado"><span class='txt-through txt-inactive'>No fue aceptada</span></div>
				<?php
				}else{
				?>
					<div class="cell flex-center" data-title="Editar" style="--color-txt:#009F41">
						<button id="btn-id-<?php echo $res->id_event;?>" onclick="aceptarPeticion(<?php echo $res->id_event;?>,this)">Aceptar</button>
					</div>
				<?php
				}
			}
			?>
		</div>
        <?php
    // }
}} ?>
