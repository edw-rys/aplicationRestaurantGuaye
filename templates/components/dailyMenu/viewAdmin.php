<?php //Sólo el administrador
if(isset($data["menu"])){
    foreach($data["menu"] as $DM){ ?>
<table>
    <thead>
        <tr>
            <th>Lo creó</th>
            <th colspan="2">Nombres y apellidos</th>

            <th>Tipo de comida</th>
            <th>Horario</th>
            <th>Comida</th>
            <!-- <th colspan="2">Descripcion/comida</th> -->
            <th>precio</th>
            <th>Categoría</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody  class="underline-a" id="id-table-evt" style="max-height: 55vh;">
        <?php 
         if(!empty($DM->getFoodControl())){
            foreach($DM->getFoodControl() as $foods){ ?>
        <tr>
            <td data-campo='Lo creó'><?php echo $foods->username;?></td>
            <td data-campo='Nombres'><?php echo $foods->name_user;?></td>
            <td data-campo='Apellidos'><?php echo $foods->last_name;?></td>
            <td data-campo='Tipo de comida'><?php echo $foods->name_TypeFood;?></td>
            <td data-campo='Horario'><?php echo $foods->name_schedule;?></td>
            <td data-campo='Comida'><?php echo $foods->name_food;?></td>
            <!-- <td colspan="2"><?php //echo $foods->description_food;?></td> -->
            <td data-campo='precio'><?php echo $foods->price;?></td>
            <td data-campo='Categoría'><?php echo $foods->name_ctgfood;?></td>
            <?php 
            if(date("Y-m-d")!=$DM->getDate_create() || $foods->id_user!=$_SESSION['ID_USER']){ ?>
            <td data-campo='Editar'><span class='txt-through txt-inactive'>Editar</span></td>
            <td data-campo='Eliminar'><span class='txt-through txt-inactive'>Eliminar</span></td>
            <?php
			}else{ ?>
            <td data-campo='Editar' style="--color-txt:#009F41"><a
                    href="#!" onclick="editFood(<?php echo $foods->id_control.','.$foods->id_food; ?>)">Editar</a>
            </td>
            <td data-campo='Eliminar' style="--color-txt:var(--color-first)"><a
                onclick="deleteMenu(<?php echo $foods->id_control; ?>,this)"
                href="#!">Eliminar</a></td>
            <?php } ?>
        </tr>
        <?php }} ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="background:white"></th>
            <th colspan="4">Fecha del menú</th>
            <th colspan="2"><?php echo $DM->getDate_create();?></th>
        </tr>
    </tfoot>
</table>
<?php }} ?>