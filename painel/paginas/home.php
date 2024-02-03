<?php 
if(@$home == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}


//totalizar pacientes
$query = $pdo->query("SELECT * from usuarios WHERE ativo ='Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_ativos = @count($res);

$query1 = $pdo->query("SELECT * from funcionarios WHERE ativo ='Sim'");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
$funcionarios_ativos = @count($res1);

//totalizar Inativos
$query2 = $pdo->query("SELECT * from usuarios WHERE ativo ='Não'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_inativos = @count($res2);

$query3 = $pdo->query("SELECT * from funcionarios WHERE ativo ='Não'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$total_func_inativos = @count($res3);


 ?>


<div class="main-page">
	<div class="col_3">

		<a href="index.php?pagina=usuarios">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded" style="background:#2a2ea3"></i>
				<div class="stats">
					<h5><strong><?php echo $total_ativos ?></strong></h5>
					<span>Usuários Ativos</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=inativos">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong> <?php echo $total_inativos ?></strong></h5>
					<span>Usuários Inativos</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=funcionarios">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong> <?php echo $funcionarios_ativos ?></strong></h5>
					<span>Func. Ativos</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=funcionarios">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong> <?php echo $total_func_inativos ?></strong></h5>
					<span>Func. Inativos</span>
				</div>
			</div>
		</div>
		</a>

		

		<div class="clearfix"> </div>
	</div>
	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>