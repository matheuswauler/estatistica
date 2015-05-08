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
	<title>Exibindo resultados</title>
	<link type="text/css" rel="stylesheet" href="default.css">
</head>
<body>
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
						<td align="center"><?= $value['minimo'] ?> ├ <?= $value['maximo'] ?></td>
						<td align="center"><?= $value['Fi'] ?></td>
						<td align="center"><?= $value['Xi'] ?></td>
						<td align="center"><?= $value['Fac'] ?></td>
						<td align="center"><?= str_replace( '.', ',', $value['fi_r'] ) ?></td>
						<td align="center"><?= str_replace( '.', ',', $value['FacR'] ) ?></td>
						<td align="center"><?= $value['Fi'] * $value['Xi'] ?></td>
					</tr>
				<?php } ?>
			</tbody>

			<tfoot>
				<tr>
					<td align="center">Total</td>
					<td align="center"><?= $CalculosEstatisticos->getDadosCount(); ?></td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">100</td>
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
					<td><?= $CalculosEstatisticos->MediaAritmeticaSimples(); ?></td>
				</tr>

				<tr>
					<th>Média Aritmética Ponderada</th>
					<td><?= $CalculosEstatisticos->MediaAritmeticaPonderada(); ?></td>
				</tr>

				<tr>
					<th>Média Geométrica</th>
					<td><?= $CalculosEstatisticos->MediaGeometricaSimples(); ?></td>
				</tr>

				<tr>
					<th>Moda</th>
					<td>
						<?php 
							$moda = $CalculosEstatisticos->Moda();
							foreach ($moda as $key => $value) {
								echo $value;
								if(count($moda) - 1 > $key){
									echo ", ";
								}
							}
						?>
					</td>
				</tr>

				<tr>
					<th>Mediana</th>
					<td><?= $CalculosEstatisticos->Mediana(); ?></td>
				</tr>

				<tr>
					<th>Variância Populacional</th>
					<td><?= $CalculosEstatisticos->VarianciaPopulacional(); ?></td>
				</tr>

				<tr>
					<th>Variância Amostral</th>
					<td><?= $CalculosEstatisticos->VarianciaAmostral(); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Populacional</th>
					<td><?= $CalculosEstatisticos->DesvioPadraoPopulacional(); ?></td>
				</tr>

				<tr>
					<th>Desvio Padrão Amostral</th>
					<td><?= $CalculosEstatisticos->DesvioPadraoAmostral(); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Populacional</th>
					<td><?= $CalculosEstatisticos->CoeficienteDeVariacaoPopulacional(); ?></td>
				</tr>

				<tr>
					<th>Coeficiente de Variação Amostral</th>
					<td><?= $CalculosEstatisticos->CoeficienteDeVariacaoAmostral(); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>