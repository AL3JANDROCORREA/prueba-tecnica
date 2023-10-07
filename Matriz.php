<?php
session_start();


// Inicializamos o recuperamos la matriz
$filas = 10;
$columnas = 5;

if (!isset($_SESSION['matriz'])) {
    $_SESSION['matriz'] = array();
    for ($i = 0; $i < $filas; $i++) {
        $_SESSION['matriz'][$i] = array();
        for ($j = 0; $j < $columnas; $j++) {
            $_SESSION['matriz'][$i][$j] = $i * $columnas + $j + 1;
        }
    }
}
if (!isset($_SESSION['puntosSeleccionados'])) {
    $_SESSION['puntosSeleccionados'] = array();
}
// Inicializamos variables
$maxPuntos = 5;

// Inicializamos una matriz para marcar celdas deshabilitadas
$celdasDeshabilitadas = array_fill(0, $filas, array_fill(0, $columnas, false));

// Función para pintar la matriz
function pintarMatriz($matriz, $puntosSeleccionados, $celdasDeshabilitadas) {
    echo "<table>";
    for ($i = 0; $i < count($matriz); $i++) {
        echo "<tr>";
        for ($j = 0; $j < count($matriz[0]); $j++) {
            echo "<td";
            if ($celdasDeshabilitadas[$i][$j]) {
                echo " class='disabled'";
            } elseif (is_array($puntosSeleccionados) && in_array($matriz[$i][$j], $puntosSeleccionados)) {
                echo " class='selected'";
            }
            echo ">";
            if (is_array($puntosSeleccionados) && in_array($matriz[$i][$j], $puntosSeleccionados)) {
                echo "X";
            } else {
                echo "<a href='?select=" . $matriz[$i][$j] . "'>" . $matriz[$i][$j] . "</a>";
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// Procesar selecciones al hacer clic en números
if (isset($_GET["select"]) && is_numeric($_GET["select"])) {
    $numeroSeleccionado = intval($_GET["select"]);
    if (!isset($_SESSION['puntosSeleccionados'])) {
        $_SESSION['puntosSeleccionados'] = array();
    }
    if (count($_SESSION['puntosSeleccionados']) < $maxPuntos && !in_array($numeroSeleccionado, $_SESSION['puntosSeleccionados'])) {
        $_SESSION['puntosSeleccionados'][] = $numeroSeleccionado;

        // Marcar fila y columna como deshabilitadas
        $filaSeleccionada = floor(($numeroSeleccionado - 1) / $columnas);
        $columnaSeleccionada = ($numeroSeleccionado - 1) % $columnas;

        // Marcar números relacionados con el seleccionado
        for ($i = 0; $i < $filas; $i++) {
            $celdasDeshabilitadas[$i][$columnaSeleccionada] = true;
        }
        for ($j = 0; $j < $columnas; $j++) {
            $celdasDeshabilitadas[$filaSeleccionada][$j] = true;
        }
    }
}

// Procesar el botón de borrar
if (isset($_POST["borrar"])) {
    unset($_SESSION['puntosSeleccionados']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriz</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .selected {
            background-color: green; /* Cambiar el color de fondo para las celdas seleccionadas */
        }
        .disabled {
            background-color: yellow; /* Cambiar el color de fondo para las celdas deshabilitadas */
            color: white; /* Cambiar el color del texto para las celdas deshabilitadas */
        }
    </style>
</head>
<body>
<h1>Oprima los numeros a deshabilitar</h1>
<form method="post">
    <input type="submit" name="borrar" value="Borrar">
</form>

<h2>Matriz:</h2>
<?php
pintarMatriz($_SESSION['matriz'], $_SESSION['puntosSeleccionados'], $celdasDeshabilitadas);

if (isset($_SESSION['puntosSeleccionados']) && count($_SESSION['puntosSeleccionados']) == $maxPuntos) {
    echo "<h3>¡Se han seleccionado 5 puntos aleatorios!</h3>";
}
?>
</body>
</html>
