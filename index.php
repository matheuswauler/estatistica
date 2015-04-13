<?php

include 'CalculosEstatisticos.class.php';

$dados = array(
	18.3,
	20.6,
	19.3,
	22.4,
	20.2,
	18.8,
	19.7,
	20.0
);

print_r($dados);

$CalculosEstatisticos = new CalculosEstatisticos($dados);

echo $CalculosEstatisticos->setCasasDecimais(2);
echo "<br />";
echo $CalculosEstatisticos->MediaAritmeticaSimples();
echo "<br />";
echo $CalculosEstatisticos->MediaGeometricaSimples();
echo "<br />";
print_r( $CalculosEstatisticos->Moda() );
echo "<br />";
echo $CalculosEstatisticos->Mediana();
echo "<br />";
echo $CalculosEstatisticos->Minimo();
echo "<br />";
echo $CalculosEstatisticos->Maximo();
echo "<br />";
echo $CalculosEstatisticos->Amplitude();
echo "<br />";
echo $CalculosEstatisticos->NumeroClasse();
echo "<br />";
echo $CalculosEstatisticos->IntervaloClasse();
echo "<br />";
echo "Frequências (Fi): ";
print_r ($CalculosEstatisticos->Frequencias());

echo "<br />";
echo "<br />";

$dados = array(
	150,151,152,154,155,155,156,156,156,157,158,160,160,160,160,161,161,161,162,162,163,163,164,164,165,166,168,168,169,170,172,173
);

$CalculosEstatisticos = new CalculosEstatisticos($dados);

echo $CalculosEstatisticos->setCasasDecimais(2);
echo "<br />";
echo "Média Aritmética Simples (X): " . $CalculosEstatisticos->MediaAritmeticaSimples();
echo "<br />";
echo "Média Aritmética Ponderada (X): " . $CalculosEstatisticos->MediaAritmeticaPonderada();

echo "<br />";
echo "Média Geométrica Simples (G): " .  $CalculosEstatisticos->MediaGeometricaSimples();
echo "<br /> Moda: ";
print_r( $CalculosEstatisticos->Moda() );
echo "<br />";
echo "Mediana (˜X): " .  $CalculosEstatisticos->Mediana();
echo "<br />";
echo "Mínimo (m): " . $CalculosEstatisticos->Minimo();
echo "<br />";
echo "Máximo (M): " . $CalculosEstatisticos->Maximo();
echo "<br />";
echo "Amplitude (R): " . $CalculosEstatisticos->Amplitude();
echo "<br />";
echo "Número de Classe (K): " . $CalculosEstatisticos->NumeroClasse();
echo "<br />";
echo "Intervalo de Classe (h): " . $CalculosEstatisticos->IntervaloClasse();
echo "<br />";
echo "Frequências (Fi): ";
print_r ($CalculosEstatisticos->Frequencias());


echo "<br />";
echo "<br />";

$dados = array(
	12,18,14,11,15
);

$CalculosEstatisticos = new CalculosEstatisticos($dados);

echo $CalculosEstatisticos->setCasasDecimais(2);
echo "<br />";
echo "Variancia Populacional (): " . $CalculosEstatisticos->VarianciaPopulacional();
echo "<br />";
echo "Variancia Amostral (S): " . $CalculosEstatisticos->VarianciaAmostral();

echo "<br />";
echo "Desvio Padrao Populacional (): " . $CalculosEstatisticos->DesvioPadraoPopulacional();
echo "<br />";
echo "Desvio Padrao Amostral (S): " . $CalculosEstatisticos->DesvioPadraoAmostral();

echo "<br />";
echo "Coeficiente De Variacao Populacional (CVp): " . $CalculosEstatisticos->CoeficienteDeVariacaoPopulacional();
echo "<br />";
echo "Coeficiente De Variacao Amostral (CVa): " . $CalculosEstatisticos->CoeficienteDeVariacaoAmostral();


echo "<br />";
echo "<br />";

$dados = array(
	2210,2255,2350,2380,2380,2390,2420,2440,2450,2550,2630,2825
);

$CalculosEstatisticos = new CalculosEstatisticos($dados);

echo $CalculosEstatisticos->setCasasDecimais(2);
echo "<br />";
echo "Variancia Populacional (): " . $CalculosEstatisticos->Quartil(3);