<?php

class CalculosEstatisticos {
	
	// Atributos
	private $dados = array(); // Contem todos os dados do problema
	private $dados_ordenados = array(); // Contem todos os dados do problema em ordem do menor para o maior
	private $dados_cont = 0; // Contem o total de de dados do problema
	private $casas_decimais = 2; // Contem a precisao de casas deciamis
	private $mapa_intervalo = array();

	public function __construct($dados = array()){
		$this->setDados($dados);
	}

	public function setDados($dados){
		$this->dados = $dados;
		$this->OrdenarDados();
		$this->dados_cont = count($this->dados);
	}

	public function setCasasDecimais($casas_decimais){
		$this->casas_decimais = $casas_decimais;
	}

	public function OrdenarDados(){
		$this->dados_ordenados = $this->dados;
		sort($this->dados_ordenados);
	}

	public function Minimo(){
		return $this->dados_ordenados[0];
	}

	public function Maximo(){
		return $this->dados_ordenados[ count( $this->dados_ordenados ) - 1 ];
	}

	public function Amplitude(){
		return $this->Maximo() - $this->Minimo();
	}

	public function NumeroClasse(){
		$K = 1 + 3.22 * log($this->dados_cont, 10);
		return round($K, 0);
	}

	public function IntervaloClasse(){
		$h = $this->Amplitude() / $this->NumeroClasse();
		$h = (int) $h + 1;
		return $h;
	}

	public function ConstruirMapaIntervalos(){
		$h = $this->IntervaloClasse();
		$minimo = $this->Minimo();
		$maximo = $this->Maximo();
		$freq = $minimo;
		$novo_intervalo = array();
		$it = 0;
		$freq_dados = $this->Frequencias();
		do{
			$novo_intervalo[$it]['minimo'] = $freq;
			$freq += $h;
			$novo_intervalo[$it]['maximo'] = $freq;
			$novo_intervalo[$it]['Xi'] = ($novo_intervalo[$it]['minimo'] + $novo_intervalo[$it]['maximo']) / 2;

			$acumulador_frequencias = 0;
			foreach ($freq_dados as $key => $value) {
				if($key >= $novo_intervalo[$it]['minimo'] && $key < $novo_intervalo[$it]['maximo']){
					$acumulador_frequencias += $value;
					echo $key . " ";
				}
			}
			echo "<br />";
			$novo_intervalo[$it]['Fi'] = $acumulador_frequencias;

			$it++;
		} while($freq <= $maximo);

		$this->mapa_intervalo = $novo_intervalo;
		return $this->mapa_intervalo;
	}

	public function MediaAritmeticaSimples($round = true){
		$contador = 0;
		foreach ($this->dados_ordenados as $valor) {
			$contador += $valor;
		}
		$media = $contador / $this->dados_cont;
		if($round){
			return round($media, $this->casas_decimais);
		} else {
			return $media;
		}
	}

	public function MediaAritmeticaPonderada($round = true){
		$mapa_intervalo = $this->mapa_intervalo;
		$somatorio = 0;
		foreach ($mapa_intervalo as $key => $value) {
			$somatorio += ($value['Xi'] * $value['Fi']);
		}
		$media_aritmetica_ponderada = $somatorio / $this->dados_cont;

		if($round){
			return round($media_aritmetica_ponderada, $this->casas_decimais);
		} else {
			return $media_aritmetica_ponderada;
		}
	}

	public function MediaGeometricaSimples($round = true){
		$contador = 1;
		foreach ($this->dados_ordenados as $valor) {
			$contador *= $valor;
		}
		$media = pow($contador, 1 / $this->dados_cont);
		if($round){
			return round($media, $this->casas_decimais);
		} else {
			return $media;
		}
	}

	public function Frequencias(){
		$mapa = array();
		foreach ($this->dados_ordenados as $chave => $valor) {
			if(array_key_exists((string) $valor, $mapa)){
				$mapa[(string) $valor]++;
			} else {
				$mapa[(string) $valor] = 1;
			}
		}
		return $mapa;
	}

	public function Moda($round = true){
		$mapa = $this->Frequencias();

		arsort($mapa);

		$moda = array();
		foreach ($mapa as $chave => $valor) {
			if(empty($moda) && $valor == 1){
				array_push($moda, 'Amodal');
				break;
			} else {
				if(empty($moda)){
					array_push($moda, $chave);
				} else {
					if($mapa[$moda[0]] == $valor){
						array_push($moda, $chave);
					} else {
						break;
					}
				}
			}
		}
		return $moda;
	}

	public function Mediana($round = true){
		$metade = count( $this->dados_ordenados ) / 2 - 1;
		if(count($this->dados_ordenados) % 2 == 0){
			$mediana = ( $this->dados_ordenados[$metade] + $this->dados_ordenados[$metade + 1] ) / 2;
		} else {
			$mediana = $this->dados_ordenados[(int) $metade + 1];
		}
		if($round){
			return round($mediana, $this->casas_decimais);
		} else {
			return $mediana;
		}
	}

	public function Quartil($i, $round = true){
		$q = (int) ($i/4 * ($this->dados_cont));
		$media = ( $this->dados_ordenados[$q - 1] + $this->dados_ordenados[$q] ) / 2;
		if($round){
			return round($media, $this->casas_decimais);
		} else {
			return $media;
		}
	}

	public function DistribuicaoAoQuadrado(){
		$distribuicao = array();
		$media = $this->MediaAritmeticaSimples();
		foreach ($this->dados_ordenados as $valor) {
			$dist = pow(($valor - $media), 2);
			array_push($distribuicao, $dist);
		}
		return $distribuicao;
	}

	public function VarianciaPopulacional($round = true){
		$distribuicao = $this->DistribuicaoAoQuadrado();
		$somatorio = 0;
		foreach ($distribuicao as $valor) {
			$somatorio += $valor;
		}
		$VarianciaPopulacional = $somatorio / $this->dados_cont;
		if($round){
			return round($VarianciaPopulacional, $this->casas_decimais);
		} else {
			return $VarianciaPopulacional;
		}
	}

	public function VarianciaAmostral($round = true){
		$distribuicao = $this->DistribuicaoAoQuadrado();
		$somatorio = 0;
		foreach ($distribuicao as $valor) {
			$somatorio += $valor;
		}
		$VarianciaPopulacional = $somatorio / ($this->dados_cont - 1);
		if($round){
			return round($VarianciaPopulacional, $this->casas_decimais);
		} else {
			return $VarianciaPopulacional;
		}
	}

	public function DesvioPadraoPopulacional($round = true){
		$desvpadp = sqrt($this->VarianciaPopulacional());
		if($round){
			return round($desvpadp, $this->casas_decimais);
		} else {
			return $desvpadp;
		}
	}

	public function DesvioPadraoAmostral($round = true){
		$desvpada = sqrt($this->VarianciaAmostral());
		if($round){
			return round($desvpada, $this->casas_decimais);
		} else {
			return $desvpada;
		}
	}

	public function CoeficienteDeVariacaoPopulacional($round = true){
		$coefVarP = $this->DesvioPadraoPopulacional() * 100 / $this->MediaAritmeticaSimples();
		if($round){
			return round($coefVarP, $this->casas_decimais);
		} else {
			return $coefVarP;
		}
	}

	public function CoeficienteDeVariacaoAmostral($round = true){
		$coefVarA = $this->DesvioPadraoAmostral() * 100 / $this->MediaAritmeticaSimples();
		if($round){
			return round($coefVarA, $this->casas_decimais);
		} else {
			return $coefVarA;
		}
	}

}