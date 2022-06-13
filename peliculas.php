<?php
include_once 'includes/db.php';


class Peliculas extends DB
{
    private $paginaActual;          //página en la que se encuentra el usuario
    private $totalPaginas;          //cantidad de páginas que existen
    private $nResultados;           //conteo de resultados que arroja la búsqueda
    private $resultadosPorPagina;   //Es bastante descriptivo el nombre
    private $indice;                //Apuntador (a partir de dónde se muestran los resultados)
    private $error = false;

    function __construct($nPorPagina)
    {
        parent::__construct();
        $this->resultadosPorPagina = $nPorPagina;
        $this->indice = 0;
        $this->paginaActual = 1;

        $this->calcularPaginas();
    }

    function calcularPaginas()
    {
        $query = $this->connect()->query('SELECT COUNT(*) AS total FROM pelicula');
        $this->nResultados = $query->fetch(PDO::FETCH_OBJ)->total;
        $this->totalPaginas = round($this->nResultados / $this->resultadosPorPagina);

        if (isset($_GET['pagina'])) {
            //Validar que página sea un número
            if (is_numeric($_GET['pagina'])) {
                //Validar que página sea mayor o igual a 1 y menor o igual a totalPaginas
                if ($_GET['pagina'] >= 1 && $_GET['pagina'] <= $this->totalPaginas) {
                    $this->paginaActual = $_GET['pagina'];
                    $this->indice = (($this->paginaActual - 1) * $this->resultadosPorPagina);
                } else {
                    echo "No existe esa página";
                    $this->error = true;
                }
            } else {
                //Desplegar error
                echo "Error al cargar la página";
                $this->error = true;
            }
        }
    }

    function mostrarPeliculas()
    {
        if (!$this->error) {
            //continuar
            $query = $this->connect()->prepare('SELECT * FROM pelicula LIMIT :posicion, :n');
            $query->execute(['posicion' => $this->indice, 'n' => $this->resultadosPorPagina]);

            foreach ($query as $pelicula) {
                include 'views/view.pelicula.php';
            }
        } else {
        }
    }

    function mostrarPaginas()
    {
        $actual = '';
        echo "<ul>";
        for ($i = 0; $i < $this->totalPaginas; $i++) {
            if (($i + 1) == $this->paginaActual) {
                $actual = ' class="actual"';
            } else {
                $actual = '';
            }

            echo '<li><a ' . filter_var($actual, FILTER_SANITIZE_URL) . ' href="?pagina=' . filter_var($i + 1, FILTER_SANITIZE_URL) . '">' . ($i + 1) . '</a></li>';
        }
        echo "</ul>";
    }
}
