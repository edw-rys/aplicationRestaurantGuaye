<header>
	<?php require_once NAVIGATION; ?>
</header>
<div class="container flex-center">
<div class="contact form flex-y flex-center">
	<h1 class="txt-center tittle tittle-sty-bck bck-t-first">Contacto</h1>
	<form class="flex-center flex-y contact grid-center" action="" method="POST" onsubmit="return validarContacto()" name="form">
		<div class="_us m-20" >
			<label><span>Nombre</span><input class="input-txt" type="text" name="nombre"></label>
			<label><span>Tu email</span><input class="input-txt" type="text" name="mail"></label>
		</div>
		<label class="message grid-center"><span class="txt-center">Asunto</span><input class="input-txt" type="text" name="asunto"></label>
		<label class="message m-20 grid-center"><span class="txt-center">Mensaje</span><textarea name="mensaje" rows="5"></textarea></label>
		<input class="button btn-first" type="submit" name="submit">
	</form>
</div>

</div>

<?php include_once INCLUDES ."footerhtml.php"?>