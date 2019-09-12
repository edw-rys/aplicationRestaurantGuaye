
	<header>
		<?php require_once NAVIGATION; ?>
		<?php 
			if(!(isset($_SESSION['USER']) && 
				isset($_SESSION['rol']) &&
					$_SESSION['rol']==CLIENTE))
				header("Location:index.php")
		?>
	</header>
	
	<div class="event container">

		<div class="form font-i-f flex-center flex-y">
			<div class="flex-center">
            <h2 class="txt-center tittle  tittle-sty-bck bck-t-green">Sus reservaciones</h2>
            </div>
			<div class="border"></div>
			<a href="index.php?c=event&a=show" style="--color-txt:var(--color-first); text-decoration:underline">Hacer una petición de una reservación</a>
		</div>
		
	</div>

	<div class="data flex-center flex-y">
	<?php if($results){

	?>
	<form action="" onsubmit="return false">
		<input type="text" placeholder="Filtrar por Asunto " onkeypress="filterByAffair(this.value)">
		<button class="button btn-first" style="cursor:pointer" onclick="filterByAffair(this.parentNode.children[0].value)">Filtrar</button>
	</form>
	<table>
			<thead>
				<th>Usuario</th>
				<th>Fecha de creación</th>
				<th>Asunto</th>
				<th>Fecha de ejecución</th>
				<th>Hora de entrada</th>
				<th>Hora de salida</th>
				<th>Comentarios</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</thead>
			<tbody class="underline-a" id="id-table-evt">
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
							<td data-campo='Editar' style="--color-txt:#009F41"><a href="index.php?c=event&a=show&id=<?php echo $res->id_event; ?>">Editar</a></td>
							<td data-campo='Eliminar' style="--color-txt:var(--color-first)"><a href="index.php?c=event&a=delete&id=
						<?php echo $res->id_event; ?>" onclick="javascript:return confirm('esta seguro?');">Eliminar</a></td>
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
		<p>Usted no ha hecho ninguna reservación</p>
		<?php 
		}
		?>

	</div>

	<div class="m-20"></div>