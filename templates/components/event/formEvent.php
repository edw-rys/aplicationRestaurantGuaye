<div class="form-clasic"  style="--color:var(--color-third)">
    <div class="header_">
		<div class="bottom-head txt-center"><h2 class="title">Nueva receta</h2></div>
	</div>
    <form onsubmit="return saveEvent()" id="formEvent">
        <?php if(isset($event)){ ?>
                <input type="hidden" value="<?php echo isset($event)?$event->getId_event():'' ?>" name="id">
        <?php } ?>
        <div class="flex-center flex-y">
            <div class="grid-2-1-m">
                <span class="container-input border-botom">
                    <input class="balloon" id="asunto" type="text" name="asunto" placeholder="Escriba el asunto." value="<?php echo isset($event)?$event->getAffair():''?>"/>
                    <label for="asunto">Asunto</label>
                </span>
                <span class="container-input border-botom">
                    <input class="balloon date" id="fecha" type="date" name="fecha" value="<?php echo isset($event)?$event->getExecutionDate():'' ?>"/>
                    <label for="fecha">Fecha</label>
                </span>
            </div>
            <div class="grid-2-1-m">
                <span class="container-input border-botom">
                    <input class="balloon txt-center" type="number" id="inHour" name="inHour" value="<?php echo isset($event)?$event->getStart_time():'7' ?>">
                    <label for="inHour">Hora de entrada</label>
                </span> 
                <span class="container-input border-botom">
                    <input class="balloon txt-center" type="number" id="outHour" name="outHour" value="<?php echo isset($event)?$event->getEnd_time():'15' ?>">
                    <label for="outHour">Hora de salida</label>
                </span>         
            </div>
            <div class="txt-area" style="width:90%">
				<label for="comentarios">
					<span class="border-bottom-unique block">Comentarios</span>
				</label>
				<div class="flex-y">
					<textarea class="border-bottom-unique no-outline" id="comentarios" name="comentarios" rows="5"><?php echo isset($event)?$event->getComments():'' ?></textarea>
				</div>
			</div>
            <div class="keypad" style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 20px;">
                    <button class="button btn-first" type="submit" name="submit">Petición</button>
                    <input class="button btn-reset" type="reset" name="" value="Restaurar valores">
                </div>
        </div>
    </form>
</div>
