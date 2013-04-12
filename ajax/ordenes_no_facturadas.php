<?php
  $user = 'wwwrun';
  $passwd = '12345';
  $db = 'gestion_prolinux';
  $port = 5432;
  $host = '10.1.1.10';
  $strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
  $cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());

  $rs = pg_query($cnx, "SELECT id, articulo, cliente, estado, moneda, subtotal, fecha_entrada FROM vs_ordenes_no_facturadas ORDER BY id DESC LIMIT 50");
?>
<!-- Fields -->
<div class="ui-block-a fields">
  <h3>Articulo</h3>
</div>
<div class="ui-block-b fields">
  <h3>Cliente</h3>
</div>
<div class="ui-block-c fields">
  <h3>Estado</h3>
</div>
<div class="ui-block-d fields">
  <h3>Subtotal</h3>
</div>
<!-- End Fields -->
<?php while($row = pg_fetch_row($rs)): ?>
<?php $class_color='verde'; ?>
<?php
  $estado=$row[3];
  $fechaHoy= time();
  $vFecha= explode("-", $row[6]);
  $fecha_entrada = mktime(0,0,0,$vFecha[1],$vFecha[2],$vFecha[0]);
  $dateDiff = $fechaHoy - $fecha_entrada;
  $fullDays = floor($dateDiff/(60*60*24));
?>

<?php if($estado == "Sin reparacion" || $estado == "Factura cancelada" || $estado == "Rep bios" || $estado == "Facturado" || $estado == "Reparado sin costo" || $estado == "Entregado sin costo" || $estado == "Reparado"): ?>
<?php $class_color='verde'; ?>
<?php else: ?>
  <?php if($fullDays >= 3): ?>
  <?php $class_color='rojo'; ?>
  <?php else: ?>
  <?php $class_color='amarillo'; ?>
  <?php endif; ?>
<?php endif; ?>

<div class="ui-block-a rows <?php echo $class_color; ?>">
  <i><?php echo $row[1]; ?></i>
</div>
<div class="ui-block-b rows <?php echo $class_color; ?>">
  <i><?php echo $row[2]; ?></i>
</div>
<div class="ui-block-c rows <?php echo $class_color; ?>">
  <i><?php echo $row[3]; ?></i>
</div>
<div class="ui-block-d rows <?php echo $class_color; ?>">
  <?php $moneda= ($row[4]==1)?'$':'U$S'; ?>
  <i><?php echo ($row[5] != '')?$moneda." ".$row[5]:''; ?>&nbsp;</i>
</div>

<?php endwhile; ?>