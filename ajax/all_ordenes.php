<?php
  $user = 'wwwrun';
  $passwd = '12345';
  $db = 'gestion_prolinux';
  $port = 5432;
  $host = '10.1.1.10';
  $strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
  $cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());

  $where= "1=1";

  $cliente= isset($_GET['cliente'])?$_GET['cliente']:'';
  if($cliente != ''){
	$where .= " AND cliente ILIKE '%".$cliente."%'";
  }

  $rs = pg_query($cnx, "SELECT id, articulo, cliente, estado, moneda, subtotal FROM vs_ordenes_all WHERE $where ORDER BY id DESC LIMIT 50");
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

<div class="ui-block-a rows">
  <i><?php echo $row[1]; ?></i>
</div>
<div class="ui-block-b rows">
  <i><?php echo $row[2]; ?></i>
</div>
<div class="ui-block-c rows">
  <i><?php echo $row[3]; ?></i>
</div>
<div class="ui-block-d rows">
  <?php $moneda= ($row[4]==1)?'$':'U$S'; ?>
  <i><?php echo ($row[5] != '')?$moneda." ".$row[5]:''; ?>&nbsp;</i>
</div>

<?php endwhile; ?>