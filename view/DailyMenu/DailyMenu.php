<header>
		<?php require_once NAVIGATION; ?>
	</header>
	<div class="m-t-100"></div>
<?php 
    //verificar usuario administrador
    if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==101 ){
        include_once "view/DailyMenu/formMenu.php";
    }
?>
<main>
    <section class="menu-diario">
        <?php 
            if(isset($dailyMenu ) && !empty($dailyMenu )){
                $menudiario=$dailyMenu[0];
        ?>
                <div class="_head font-barriecito flex-center">
                    <div class="_container flex-center">
                        <p class="date">Fecha: <?php echo $menudiario->getDate_create();?></p>
                        <img class="picture" src="assets/img/icons/calendar.png" alt="">
                    </div>
                </div>
                <div class="_main font-i-f">
                    <?php 
						if( isset($schedules) && !empty($schedules) ){
                            foreach($schedules as $sc){
                                ?>
                                <div class="section-foods">
                                <div class="schedule">
                                    <p class="txt-center"><?php echo $sc->getName_schedule();?></p>
                                </div>
                                <div class="foods">
                                <?php
                                foreach($menudiario->getFoodControl() as $foods){
                                    if($foods->id_schedule==$sc->getId_schedule()){
                                ?>
                                <div class="food">
                                    <div class="detail">
                                        <p class="name grid-center"><?php echo $foods->name_food; ?></p>
                                        <p class="description grid-center"><?php echo $foods->description_food; ?></p>
                                    </div>
                                    <div class="price grid-center"><p>$ <?php echo $foods->price; ?></p></div>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                                </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="_foot flex-center flex-y font-barriecito">
                        <p class="f1--">Horario de atención</p>
                        <p class="f1--">Lunea a sábado de 7:30 am a 5 pm</p>
                        <span><i class="fas fa-mobile-alt"></i>0996567336 / <i class="fas fa-phone"></i> (04) 2567928</span>
                        <span><i class="fas fa-envelope-open-text"></i> guaye-restaurant@hotmail.com</span>
                </div>
                <?php
            }else{
                ?>
                <div>
                    <p>No existen datos para el menú</p>
                </div>
                <?php
            }
        ?>
    </section>
    <?php
        //Sólo el administrador
        if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==101 ){
            if(isset($dailyMenu )){
            foreach($dailyMenu as $DM){
        ?>
        <table>
            <thead>
				<tr>
                <th>Lo creó</th>
				<th colspan="2">Nombres y apellidos</th>

				<th>Tipo de comida</th>
				<th>Horario</th>
				<th>Comida</th>
				<th colspan="2">Descripcion/comida</th>
				<th>precio</th>
				<th>Categoría</th>
				<th>Editar</th>
				<th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(!empty($DM->getFoodControl())){
                    // echo date_default_timezone_get();
                     
                    date_default_timezone_set("America/Guayaquil");
                    foreach($DM->getFoodControl() as $foods){
                ?>
                <tr>
                    <td><?php echo $foods->username;?></td>
                    <td><?php echo $foods->name_user;?></td>
                    <td><?php echo $foods->last_name;?></td>
                    <td><?php echo $foods->name_TypeFood;?></td>
                    <td><?php echo $foods->name_schedule;?></td>
                    <td><?php echo $foods->name_food;?></td>
                    <td colspan="2"><?php echo $foods->description_food;?></td>
                    <td><?php echo $foods->price;?></td>
                    <td><?php echo $foods->name_ctgfood;?></td>
                    <?php 
                    
                    if(date("Y-m-d")!=$DM->getDate_create() || $foods->id_user!=$_SESSION['ID_USER']){
					?>
						<td data-campo='Editar'><span class='txt-through txt-inactive'>Editar</span></td>
						<td data-campo='Eliminar'><span class='txt-through txt-inactive'>Eliminar</span></td>
					<?php
					}else{
					?>
						<td data-campo='Editar' style="--color-txt:#009F41"><a href="index.php?c=dailymenu&a=view&idc=<?php echo $foods->id_control."&idf=".$foods->id_food; ?>">Editar</a></td>
						<td data-campo='Eliminar' style="--color-txt:var(--color-first)"><a href="index.php?c=dailymenu&a=delete&idc=<?php echo $foods->id_control; ?>" onclick="javascript:return confirm('esta seguro?');">Eliminar</a></td>
					<?php
					}
					?>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="background:white"></th>
                    <th colspan="3">Fecha del menú</th>
                    <th colspan="3"><?php echo $DM->getDate_create();?></th>
                </tr>
            </tfoot>
        </table>
        <?php
            }
            }
        }
    ?>
</main>