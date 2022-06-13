<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginations</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    include_once 'peliculas.php';

    $peliculas = new Peliculas(2);

    ?>
    <div id="container">
        <div id="paginas">
            <?php $peliculas->mostrarPaginas(); ?>
        </div>
        <div id="peliculas">
            <?php $peliculas->mostrarPeliculas(); ?>
        </div>
    </div>
</body>

</html>