<?php

	include 'CalculosEstatisticos.class.php';

	$dados = array(
		150,151,152,153,154,155,155,155,156,156,156,157,158,158,160,160,160,160,160,161,161,161,161,162,162,163,163,164,164,164,165,166,167,168,168,169,170,170,172,173
	);

	$CalculosEstatisticos = new CalculosEstatisticos($dados);

	$CalculosEstatisticos->setCasasDecimais(2);
	$tabela = $CalculosEstatisticos->ConstruirMapaIntervalos();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table width="100%">
		<thead>
			<tr>
				<th>X</th>
				<th>Fi</th>
				<th>Xi</th>
				<th>Fac</th>
				<th>fi(%)</th>
				<th>FacR(%)</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($tabela as $key => $value) { ?>
				<tr>
					<td align="center"><?= $value['minimo'] ?> |- <?= $value['maximo'] ?></td>
					<td align="center"><?= $value['Fi'] ?></td>
					<td align="center"><?= $value['Xi'] ?></td>
					<td align="center"><?= $value['Fac'] ?></td>
					<td align="center"><?= $value['fi_r'] ?></td>
					<td align="center"><?= $value['FacR'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>