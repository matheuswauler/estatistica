<?php

class CalculosEstatisticos {
	
	// Atributos
	private $dados = array(); // Contem todos os dados do problema
	private $dados_ordenados = array(); // Contem todos os dados do problema em ordem do menor para o maior
	private $dados_cont = 0; // Contem o total de de dados do problema
	private $casas_decimais = 2; // Contem a precisao de casas deciamis

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

	public function Moda($round = true){
		$mapa = array();
		foreach ($this->dados_ordenados as $chave => $valor) {
			if(array_key_exists((string) $valor, $mapa)){
				$mapa[(string) $valor]++;
			} else {
				$mapa[(string) $valor] = 1;
			}
		}

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
			$mediana = $this->dados_ordenados[(int) $metade];
		}
		if($round){
			return round($mediana, $this->casas_decimais);
		} else {
			return $mediana;
		}
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

}