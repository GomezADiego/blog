<?php 

    if(!isset($_POST['busqueda'])){
        header("location: index.php");
    }

?>

<?php require_once 'includes/cabecera.php' ?>
<?php require_once 'includes/lateral.php' ?>

<!-- CAJA PRINCIPAL -->
<div id="principal">

    <h1>Busqueda: <?= $_POST['busqueda'] ?></h1>
    
    <?php 
        $entradas = conseguirEntradas($db, null, null, $_POST['busqueda']); 

        if(!empty($entradas) && mysqli_num_rows($entradas) >= 1):
            while($entrada = mysqli_fetch_assoc($entradas)):
    ?>
     <article class="entrada">
        <a href="entrada.php?id=<?=$entrada['id']?>">
            <h2><?= $entrada['titulo'] ?></h2>
            <span class="fecha"><?= $entrada['categoria'].' | '.$entrada['fecha'] ?> </span>
            <p>
                <?= substr($entrada['descripcion'], 0, 300)."..." ?>
            </p>
        </a>
    </article>
    <?php 
            endwhile;
        else:
    ?>
        <div class="alerta"> no hay entradas en esta categoria </div>
    <?php endif; ?>

</div> <!--FIN PRINCIPAL -->


<?php require_once 'includes/pie.php' ?>