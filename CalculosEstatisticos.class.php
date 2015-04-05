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

	public function Moda(){
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

	public function OrdenaDescrescente($a, $b){
		return $a > $b;
	}

	public function Arredondar($valor){
		$valor_string = (string) $valor;
		$decimais = explode('.', $valor_string);
		if(count($decimais) == 1){ // se NAO ha numeros depois da virgula
			$arredondado = $valor;
		} else { // se ha numeros apos a virgula
			$numero_casas_decimais = strlen($decimais[1]);
			if($numero_casas_decimais <= $this->casas_decimais){ // Se o numero de casas decimais do valor for MENOR do que a precisao solicitada
				$arredondado = $valor;
			} else { // Se o numero de casas decimais do valor for MAIOR do que a precisao solicitada
				$cortado = (int) substr($decimais[1], $this->casas_decimais, 1);
				if($cortado == 5){ // Se o valor de corte for 5 entra na regra do 5
					if($this->casas_decimais == 0){ // Se o numero de casas decimais for 0 o numero arredondado vai ser o inteiro
						$a_ser_arredondado = (int) $decimais[0];
						$resto = (int) substr($decimais[1], 1);
						if($a_ser_arredondado%2 == 0 && $resto == 0){
							$arredondado = $a_ser_arredondado;
						} else {
							$arredondado = $a_ser_arredondado + 1;
						}
					} else { // Se o numero de casas decimais for maior que 0 o arredondado vai ser o numero anterior ao de corte
						
					}
				} else { // Se o valor de corte NAO for 5, arredonda normalmente
					$arredondado = round($valor, $this->casas_decimais);
				}
			}
		}
		return $arredondado;
	}

}