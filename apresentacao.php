<?php

	include 'CalculosEstatisticos.class.php';

	/*$dados = array(
		150,151,152,153,154,155,155,155,156,156,156,157,158,158,160,160,160,160,160,161,161,161,161,162,162,163,163,164,164,164,165,166,167,168,168,169,170,170,172,173
	);*/
	if( empty($_POST) ) {
		exit;
	}

	$dados = str_replace(',', '.', $_POST['sequencia_dados']);
	$dados = explode(';', $dados);

	$CalculosEstatisticos = new CalculosEstatisticos($dados);

	$CalculosEstatisticos->setCasasDecimais(1);
	$tabela = $CalculosEstatisticos->ConstruirMapaIntervalos();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Exibindo resultados</title>
	<link type="text/css" rel="stylesheet" href="default.css">
</head>
<body>
	<header>
		<div class="content">
			Estatística Aplicada a Computação
		</div>
	</header>

	<div class="content">
		<h1>Tabela de distribuição de frequência</h1>

		<table width="100%" class="distribuicao_de_frequencias">
			<thead>
				<tr>
					<th>X</th>
					<th>Fi</th>
					<th>Xi</th>
					<th>Fac</th>
					<th>fi(%)</th>
					<th>FacR(%)</th>
					<th>XiFi</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($tabela as $key => $value) { ?>
					<tr>
						<td align="center"><?= number_format($value['minimo'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?> ├ <?= number_format($value['maximo'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
						<td align="center"><?= $value['Fi'] ?></td>
						<td align="center"><?= number_format($value['Xi'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
						<td align="center"><?= $value['Fac'] ?></td>
						<td align="center"><?= number_format($value['fi_r'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
						<td align="center"><?= number_format($value['FacR'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
						<td align="center"><?= number_format($value['Fi'] * $value['Xi'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
					</tr>
				<?php } ?>
			</tbody>

			<tfoot>
				<tr>
					<td align="center">Total</td>
					<td align="center"><?= $CalculosEstatisticos->getDadosCount(); ?></td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center"><?= number_format($tabela[count($tabela) - 1]['FacR'], $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
					<td align="center">-</td>
					<td align="center">-</td>
				</tr>
			</tfoot>
		</table>

		<h1>Medidas de tendência central</h1>

		<table class="resultados">
			<tbody>
				<tr>
					<th>Média Aritmética Simples</th>
					<td><?= number_format($CalculosEstatisticos->MediaAritmeticaSimples(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Média Aritmética Ponderada</th>
					<td><?= number_format($CalculosEstatisticos->MediaAritmeticaPonderada(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Média Geométrica</th>
					<td><?= number_format($CalculosEstatisticos->MediaGeometricaSimples(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Moda</th>
					<td>
						<?php 
							$moda = $CalculosEstatisticos->Moda();
							foreach ($moda as $key => $value) {
								if($value != "Amodal"){
									echo number_format($value, $CalculosEstatisticos->getCasasDecimais(), ',', '.');
								} else {
									echo $value;
								}
								if(count($moda) - 1 > $key){
									echo ", ";
								}
							}
						?>
					</td>
				</tr>

				<tr>
					<th>Mediana</th>
					<td><?= number_format($CalculosEstatisticos->Mediana(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Variância Populacional</th>
					<td><?= number_format($CalculosEstatisticos->VarianciaPopulacional(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Variância Amostral</th>
					<td><?= number_format($CalculosEstatisticos->VarianciaAmostral(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Populacional</th>
					<td><?= number_format($CalculosEstatisticos->DesvioPadraoPopulacional(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Amostral</th>
					<td><?= number_format($CalculosEstatisticos->DesvioPadraoAmostral(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Populacional</th>
					<td><?= number_format($CalculosEstatisticos->CoeficienteDeVariacaoPopulacional(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Amostral</th>
					<td><?= number_format($CalculosEstatisticos->CoeficienteDeVariacaoAmostral(), $CalculosEstatisticos->getCasasDecimais(), ',', '.'); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>