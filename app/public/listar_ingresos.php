<?php
include '../includes/config.php';
include '../includes/check_login.php';

$conn = getDB();
$items_por_pagina = 10;

// Contar el total de ingresos
$sql = "SELECT COUNT(*) as total FROM ingresos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$total_ingresos = $result->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_ingresos / $items_por_pagina);

// Obtener la página actual
$pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$pagina_actual = max($pagina_actual, 1);
$pagina_actual = min($pagina_actual, $total_paginas);

// Calcular el desplazamiento para la consulta
$offset = ($pagina_actual - 1) * $items_por_pagina;

// Obtener ingresos para la página actual
$sql = "SELECT * FROM ingresos WHERE usuario_id = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $_SESSION['user_id'], $items_por_pagina, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Ingresos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../js/scripts.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Listado de Ingresos</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Valor</th>
                    <th>Forma de Pago</th>
                    <th>Tercero</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo number_format($row['valor'], 2); ?></td>
                        <td><?php echo $row['forma_pago_id']; ?></td>
                        <td><?php echo $row['tercero_id']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Controles de paginación -->
        <nav aria-label="Página de navegación">
            <ul class="pagination">
                <li class="page-item <?php if ($pagina_actual <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?pagina=<?php echo max(1, $pagina_actual - 1); ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                    <li class="page-item <?php if ($i == $pagina_actual) echo 'active'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($pagina_actual >= $total_paginas) echo 'disabled'; ?>">
                    <a class="page-link" href="?pagina=<?php echo min($total_paginas, $pagina_actual + 1); ?>" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <a class="btn btn-primary" href="ingreso_form.php">Registrar Ingreso</a>
    </div>
</body>
</html>
