
	<header>
		<?php require_once NAVIGATION; ?>
		<?php 
			if(!(isset($_SESSION['USER']) && 
				isset($_SESSION['rol']) &&
					$_SESSION['rol']==ADMINISTRADOR))
				header("Location:index.php")
		?>
	</header>
	
	<div class="event container">

		<div class="form font-i-f flex-center flex-y">
			<div class="flex-center">
            <h2 class="txt-center tittle  tittle-sty-bck bck-t-green">Peticiones hechas</h2>
            </div>
			<div class="border"></div>
		</div>
		
	</div>
	<div class="data flex-center flex-y">
	<?php if(isset($results)){
	?>
	<table>
			<thead>
				<th>Usuario</th>
				<th>Fecha de creación</th>
				<th>Asunto</th>
				<th>Fecha de ejecución</th>
				<th>Hora de entrada</th>
				<th>Hora de salida</th>
				<th>Comentarios</th>
				<th>Estado</th>
			</thead>
			<tbody class="underline-a">
			<?php
				foreach($results as $res)	{
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
						<td data-campo='Aceptación' class="txt-center">Aceptado</td>
					<?php
					}
					else{
                        if(date("Y-m-d")> $res->execution_date){
                    ?>
                        <td data-campo='Estado' class="txt-center"><span class='txt-through txt-inactive'>No fue aceptada</span></td>
                    <?php
                        }else{
                    ?>
						<td data-campo='Estado' style="--color-txt:#02F379" class="flex-center">
						<button id="btn-id-<?php echo $res->id_event;?>" onclick="aceptarPeticion(<?php echo $res->id_event;?>,'#btn-id-<?php echo $res->id_event;?>')">Aceptar</button>
						</td>
                    <?php
                        }
					}
					?>

				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
		<?php }else{
		?>
		<p>No han hecho peticiones</p>
		<?php 
		}
		?>

	</div>

	<div class="m-20"></div>