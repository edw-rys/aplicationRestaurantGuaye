<?php
if(isset($data["events"])){
	foreach($data["events"] as $res){
		?>
		<div class="row-table" target-name="event-id-<?php echo $res->id_event?>">
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
				<div class="cell" data-title="Estado">Aceptado</div>
				<?php
			}
			else{
				if(date("Y-m-d")>$res->execution_date){
				?>
					<div class="cell" data-title=""><span class='txt-through txt-inactive'>Editar</span></div>
					<div class="cell" data-title=""><span class='txt-through txt-inactive'>Eliminar</span></div>
				<?php
				}else{
				?>
					<div class="cell" data-title="" style="--color-txt:#009F41"><a href="#!" onclick="editEvent(<?php echo $res->id_event; ?>)">Editar</a></div>
					<div class="cell" data-title="" style="--color-txt:var(--color-first)"><a onclick="deleteEvent(<?php echo $res->id_event; ?>, this.parentNode)" href="#!">Eliminar</a></div>
				<?php
				}
			}
			?>
		</div>
        <?php
    }
}
?>
