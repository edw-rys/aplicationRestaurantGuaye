<?php
if(isset($data["events"])){
	foreach($data["events"] as $res){ ?>
        <tr>
			<td data-campo='Usuario'><?php echo $res->name_user; ?></td>
			<td data-campo='Fecha de creación'><?php echo $res->creation_date; ?></td>
			<td data-campo='Asunto'><?php echo $res->affair; ?></td>
			<td data-campo='Fecha de ejecución'><?php echo $res->execution_date; ?></td>
			<td data-campo='Hora de entrada'><?php echo $res->start_time; ?></td>
			<td data-campo='Hora de salida'><?php echo $res->end_time; ?></td>
			<td data-campo='Comentarios'><?php echo $res->comment; ?></td>

			<?php 
			if($res->is_accepted==1){
				?>
				<td data-campo='Aceptación' class="txt-center">Aceptado</td>
			<?php
			}
			else{
				if(date("Y-m-d")>$res->execution_date){
				?>
                    <td data-campo='Estado' class="txt-center"><span class='txt-through txt-inactive'>No fue aceptada</span></td>
				<?php
				}else{
				?>
					<td data-campo='Estado' style="--color-txt:#02F379" class="flex-center">
						<button id="btn-id-<?php echo $res->id_event;?>" onclick="aceptarPeticion(<?php echo $res->id_event;?>,this)">Aceptar</button>
					</td>
				<?php
				}
			}
			?>

		</tr>
        <?php
    // }
}} ?>
