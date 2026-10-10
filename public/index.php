<?php
declare(strict_types=1);

date_default_timezone_set('America/La_Paz');

// Cargar los productos desde datos.php
$productos = require __DIR__ . '/../datos.php';
// TODO 1: cargar el arreglo de productos desde ../datos.php con require (datos FUERA de public/)
/*esto se comento para incluir lo de arriba require*/
//$productos = [];

/** Escapa texto para HTML (evita que un dato como "<b>" se interprete como etiqueta). */

/*function e(string $texto): string
{
    // TODO 2: usar htmlspecialchars con ENT_QUOTES y 'UTF-8'
    return $texto;
}*/
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/** Formato boliviano: Bs 1.234,50 */
/*function bs(float $monto): string
{
    // TODO 3: number_format con 2 decimales, coma decimal y punto de miles, precedido de "Bs "
    return (string) $monto;
}*/
function bs(float $monto): string
{
    return 'Bs ' . number_format($monto, 2, ',', '.');
}

// TODO 4: contar en $disponibles los productos con stock mayor a 0 (usa foreach)
//$disponibles = 0; estaba solo asi para luego colocar el foreach de productos

$disponibles = 0;
foreach ($productos as $producto) {
    if ($producto['stock'] > 0) {
        $disponibles++;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo · Apicultores Flor de la Chiquitanía</title>
  <link rel="stylesheet" href="/css/estilo.css">
</head>
<body>
  <header>
    <h1>Apicultores Flor de la Chiquitanía</h1>
    <p><?= count($productos) ?> productos · <?= $disponibles ?> disponibles</p>
  </header>
  <main>
    <table>
      <caption>Catálogo de la asociación</caption>
      <thead>
        <tr><th scope="col">Código</th><th scope="col">Producto</th><th scope="col">Categoría</th>
            <th scope="col">Socio</th><th scope="col">Precio</th><th scope="col">Stock</th></tr>
      </thead>
      <!--aqui se cambio el tr por la consulta-->
<?php foreach ($productos as $p): ?>  
  <tr<?= $p['stock'] === 0 ? ' class="agotado"' : '' ?>>
    <td><?= e($p['codigo']) ?></td>
    <td><?= e($p['nombre']) ?></td>
    <td><?= e($p['categoria']) ?></td>
    <td><?= e($p['socio']) ?></td>
    <td class="num"><?= e(bs($p['precio'])) ?></td>
    <td class="num">
      <?php if ($p['stock'] === 0): ?>
        <span class="insignia">Agotado</span>
      <?php else: ?>
        <?= e((string) $p['stock']) ?>
      <?php endif; ?>
    </td>
  </tr>
<?php endforeach; ?>
</tbody>
    </table>
  </main>
  <footer>
    <!-- TODO 6: "Generado por el servidor el dd/mm/aaaa a las hh:mm con PHP x.y" (date() y PHP_MAJOR_VERSION/PHP_MINOR_VERSION) -->
    <!--<p>Generado por el servidor</p>-->
    <!--esto es lo que se adiciono-->
    <p>Generado por el servidor el <?= date('d/m/Y') ?> a las <?= date('H:i') ?> con PHP <?= PHP_MAJOR_VERSION ?>.<?= PHP_MINOR_VERSION ?></p>
  </footer>
</body>
</html>
