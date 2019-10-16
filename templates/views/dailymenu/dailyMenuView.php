<header>
    <?php require_once NAVIGATION; ?>
</header>


<?php 
    //verificar usuario administrador
    if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==ADMINISTRADOR ){
        echo '<div class="despliegue"></div>';
		echo '<div class="flex-center"><button class="button-new-recipe" onclick="getFormDilyMenu()">Nueva receta</button></div>';
        // echo "<button>Nuevo</button>";
    }
?>
<main>
    <section class="menu-diario">
    <?php 
    if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==ADMINISTRADOR ){
        echo "<div class='data'>";
        
        include_once COMPONENTS."dailymenu/viewAdmin.php";
        echo "</div>";
    }
    elseif(isset($data["menu"] ) && !empty($data["menu"] )){
        $menudiario=$data["menu"];
        include_once COMPONENTS."dailymenu/viewUser.php";
    }else{?>
        <div>
            <p>No existen datos para el menú</p>
        </div>
    <?php }?>
    </section>
</main>