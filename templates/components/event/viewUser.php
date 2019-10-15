<?php
if(isset($data["events"])){
	foreach($data["events"] as $res){
        ?>
        <tr>
			<td  data-campo='Usuario'><?php echo $res->name_user; ?></td>
			<td data-campo='Fecha de creación'><?php echo $res->creation_date; ?></td>
			<td data-campo='Asunto'><?php echo $res->affair; ?></td>
			<td data-campo='Fecha de ejecución'><?php echo $res->execution_date; ?></td>
			<td data-campo='Hora de entrada'><?php echo $res->start_time; ?></td>
			<td data-campo='Hora de salida'><?php echo $res->end_time; ?></td>
			<td data-campo='Comentarios'><?php echo $res->comment; ?></td>

			<?php 
			if($res->is_accepted==1){
				?>
				<td data-campo='Aceptación' colspan="2" class="txt-center">Aceptado</td>
				<?php
			}
			else{
				if(date("Y-m-d")>$res->execution_date){
				?>
					<td data-campo='Editar'><span class='txt-through txt-inactive'>Editar</span></td>
					<td data-campo='Eliminar'><span class='txt-through txt-inactive'>Eliminar</span></td>
				<?php
				}else{
				?>
					<td data-campo='Editar' style="--color-txt:#009F41"><a href="#!" onclick="editEvent(<?php echo $res->id_event; ?>)">Editar</a></td>
					<td data-campo='Eliminar' style="--color-txt:var(--color-first)"><a onclick="deleteEvent(<?php echo $res->id_event; ?>, this.parentNode)" href="#!">Eliminar</a></td>
				<?php
				}
			}
			?>

		</tr>
        <?php
    }
}
?>
