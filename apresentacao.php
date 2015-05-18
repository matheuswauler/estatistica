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

	$CalculosEstatisticos->setCasasDecimais(2);
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
						<td align="center"><?= number_format($value['minimo'], 2, ',', '.'); ?> ├ <?= number_format($value['maximo'], 2, ',', '.'); ?></td>
						<td align="center"><?= $value['Fi'] ?></td>
						<td align="center"><?= number_format($value['Xi'], 2, ',', '.'); ?></td>
						<td align="center"><?= $value['Fac'] ?></td>
						<td align="center"><?= number_format($value['fi_r'], 2, ',', '.'); ?></td>
						<td align="center"><?= number_format($value['FacR'], 2, ',', '.'); ?></td>
						<td align="center"><?= number_format($value['Fi'] * $value['Xi'], 2, ',', '.'); ?></td>
					</tr>
				<?php } ?>
			</tbody>

			<tfoot>
				<tr>
					<td align="center">Total</td>
					<td align="center"><?= $CalculosEstatisticos->getDadosCount(); ?></td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center"><?= number_format($tabela[count($tabela) - 1]['FacR'], 2, ',', '.'); ?></td>
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
					<td><?= number_format($CalculosEstatisticos->MediaAritmeticaSimples(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Média Aritmética Ponderada</th>
					<td><?= number_format($CalculosEstatisticos->MediaAritmeticaPonderada(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Média Geométrica</th>
					<td><?= number_format($CalculosEstatisticos->MediaGeometricaSimples(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Moda</th>
					<td>
						<?php 
							$moda = $CalculosEstatisticos->Moda();
							foreach ($moda as $key => $value) {
								if($value != "Amodal"){
									echo number_format($value, 2, ',', '.');
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
					<td><?= number_format($CalculosEstatisticos->Mediana(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Variância Populacional</th>
					<td><?= number_format($CalculosEstatisticos->VarianciaPopulacional(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Variância Amostral</th>
					<td><?= number_format($CalculosEstatisticos->VarianciaAmostral(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Populacional</th>
					<td><?= number_format($CalculosEstatisticos->DesvioPadraoPopulacional(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Amostral</th>
					<td><?= number_format($CalculosEstatisticos->DesvioPadraoAmostral(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Populacional</th>
					<td><?= number_format($CalculosEstatisticos->CoeficienteDeVariacaoPopulacional(), 2, ',', '.'); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Amostral</th>
					<td><?= number_format($CalculosEstatisticos->CoeficienteDeVariacaoAmostral(), 2, ',', '.'); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>