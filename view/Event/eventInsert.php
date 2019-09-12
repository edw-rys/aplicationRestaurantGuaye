
	<header>
		<?php require_once NAVIGATION; ?>
		<?php 
			if(!(isset($_SESSION['USER']) && 
				isset($_SESSION['rol']) &&
					$_SESSION['rol']==102))
				header("Location:index.php")
		?>
	</header>
	
	<div class="event container">

		<div class="form font-i-f flex-center flex-y">
			<div class="flex-center">
            <h2 class="txt-center tittle  tittle-sty-bck bck-t-green">Petición de reservación</h2>
            </div>
			<div class="border"></div>
            <p style="--color-txt: var(--color-first); ">
			    <a href="index.php?c=event&a=query" style="text-decoration:underline">Eventos</a>
                <span>  ->  Hacer una petición de una reservación</span>
            </p>
			<div class="border"></div>
			<form action="index.php?c=event&a=saveEvent"  onsubmit="return validaFormEventos()" method="POST">
				<?php
					if(isset($event)){
						?>
						<input type="hidden" value="<?php echo isset($event)?$event->getId_event():'' ?>" name="id">
						<?php
					}
				?>

				<label>
                    <span>Asunto</span>
                    <input type="text" name="asunto" value="<?php echo isset($event)?$event->getAffair():'' ?>">
                </label>
				<label>
                    <span>Fecha</span>
                    <input type="date" name="fecha" value="<?php echo isset($event)?$event->getExecutionDate():'' ?>">
                </label>
				<label>
                    <span>Hora de entrada</span>
                    <input type="number" name="inHour" value="<?php echo isset($event)?$event->getStart_time():'7' ?>">
                </label>
				<label>
                    <span>Hora de salida</span>
                    <input type="number" name="outHour" value="<?php echo isset($event)?$event->getEnd_time():'15' ?>">
                </label>
				<label>
                    <span>Comentarios </span>
                    <textarea name="comentarios"><?php echo isset($event)?$event->getComments():'' ?></textarea>
                </label>
				<!-- <label><span>Recibir respuesta al correo electrónico: <input type="checkbox" name="chk" value="yes"></span></label> -->
				<!-- botonera -->
				<div class="keypad" style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 20px;">
					<input class="button btn-first" type="submit" name="" value="Petición">
					<input class="button btn-reset" type="reset" name="" value="Restaurar valores">
				</div>
			</form>
		</div>

	</div>