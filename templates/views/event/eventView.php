<header>
	<?php require_once NAVIGATION; ?>
	<?php 
		if(!isset($_SESSION['USER']))
			Redirect::to("");
	?>
</header>
<div class="event container">
	<div class="<?php echo $_SESSION["rol"]!=ADMINISTRADOR?'form':''?> font-i-f flex-center flex-y">
		<div class="flex-center">
		<h2 class="txt-center tittle  tittle-sty-bck bck-t-green">Sus reservaciones</h2>
		</div>
		<div class="border"></div>
		<?php if(isset($_SESSION["rol"]) && $_SESSION["rol"]!=ADMINISTRADOR){
			echo '<button class="button-new-recipe" onclick="getFormEvent()">Nueva petición</button>';	
		}?>
	</div>
</div>

<div class="data flex-center flex-y">
<?php if(isset($data["events"])){ ?>
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
        <?php if($_SESSION["rol"]==ADMINISTRADOR){?>
        <th>Estado</th>
        <?php }else{?>
		<th>Editar</th>
		<th>Eliminar</th>
        <?php }?>
	</thead>
	<tbody class="underline-a"  id="body_table_event">
	<?php
        if(isset($_SESSION["rol"]) && $_SESSION["rol"]==ADMINISTRADOR){
            require_once COMPONENTS."event/viewAdmin.php";
        }else{
            require_once COMPONENTS."event/viewUser.php";
        }
	?>
	</tbody>
</table>    <?php }else{
    echo $_SESSION["rol"]==ADMINISTRADOR?"NO HAY RESERVACIONES":"Usted no ha hecho ni una reservación";
} ?>
</div>  
<div class="m-20"></div>