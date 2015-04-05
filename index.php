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
echo "<br />";

$dados = array(
	0.53,
	0.46,
	0.50,
	0.49,
	0.52,
	0.53,
	0.44,
	0.55,
);

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

// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3);
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.7) . ' Não esquecer de arredondar os inteiros quando for precision 0';
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(4.5) . ' ';
// echo $CalculosEstatisticos->Arredondar(4.501) . ' ';
// echo $CalculosEstatisticos->Arredondar(5) . ' ';
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.2432);
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.2678);
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.450);
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.350);
// echo "<br />";
// echo $CalculosEstatisticos->Arredondar(3.85001);
