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

	public function getDadosCount(){
		return $this->dados_cont;
	}

	public function setCasasDecimais($casas_decimais){
		$this->casas_decimais = $casas_decimais;
	}

	public function getCasasDecimais(){
		return $this->casas_decimais;
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

	/**
	Faz a construção de uma mapa com todos os dados para formar a tabela de distribuição de frequência
	*/
	public function ConstruirMapaIntervalos(){
		$h = $this->IntervaloClasse(); // Contem o intervalo de classe
		$minimo = $this->Minimo(); // Contem valor mínimo da sequência de dados
		$maximo = $this->Maximo(); // Contem valor máximo da sequência de dados
		$freq = $minimo; // Esta variável é utilizada para controlar os intervalos de dados
		$novo_intervalo = array(); // Nesta variavel ficam armazenadas todas as linhas da tabela com todas as colunas
		$it = 0; // Iterador do laço
		$freq_dados = $this->Frequencias(); // Array que tem todas as frequências dos dados de entrada
		$Fac = 0; // Variável de controle da Frequência Acumulada
		$FacR = 0; // Variável de controle da Frequência Acumulada Relativa

		// Inicia o laço na primeira iteração
		do{
			$novo_intervalo[$it]['minimo'] = $freq; // Grava o valor mínimo do intervalo
			$freq += $h; // Acrescenta no controlador dos intervalos
			$novo_intervalo[$it]['maximo'] = $freq; // Grava o valor máximo do intervalo
			$novo_intervalo[$it]['Xi'] = ($novo_intervalo[$it]['minimo'] + $novo_intervalo[$it]['maximo']) / 2; // Grava a média dos pontos do intervalo

			$acumulador_frequencias = 0; // Acumulador da frequência de dados que se encaixam no intervalo
			foreach ($freq_dados as $key => $value) {
				if($key >= $novo_intervalo[$it]['minimo'] && $key < $novo_intervalo[$it]['maximo']){
					$acumulador_frequencias += $value;
				}
			}

			$novo_intervalo[$it]['Fi'] = $acumulador_frequencias; // Adiciona a frequência de dados para este intervalo
			$Fac += $acumulador_frequencias; // Acrescenta no contador de frequência acumulada
			$novo_intervalo[$it]['Fac'] = $Fac; // Adiciona a frequência acumulada no mapa

			// Faz o cálculo do fi(%), frequência relativa
			$fi = round( $acumulador_frequencias * 100 / $this->dados_cont, $this->casas_decimais );
			$novo_intervalo[$it]['fi_r'] = $fi; // Adiciona a frequência relativa no mapa
			$FacR += $fi;
			$novo_intervalo[$it]['FacR'] = $FacR; // Adiciona a frequência relativa acumulada no mapa

			$it++; // Acrescenta no iterador
		} while($freq <= $maximo); // Faz o teste de parada do laço while

		// Este if apenas executa caso o a soma das frequências relativas não feche 100%
		if($FacR != 100){
			$indice_do_maior = 0; // Grava o índice (linha da tabela) do maior valor fi(%)
			$guarda_maior = 0; // Grava o valor do maior fi(%) para comparação

			// Este laço procura pelo maior fi(%) da tabela
			foreach ($novo_intervalo as $it => $linha) {
				if($guarda_maior < $linha['fi_r']){
					$guarda_maior = $linha['fi_r'];
					$indice_do_maior = $it;
				}
			}

			$novo_intervalo[$indice_do_maior]['fi_r'] = $guarda_maior + (100 - $FacR); // Realiza a alteração do maior fi(%) com a diferença que falta do FacR para 100%

			// Este trecho recalcula todo o FacR novamente depois de atualizar o valor do fi(%)
			$FacR = 0;
			foreach ($novo_intervalo as $it => $linha) {
				$FacR += $linha['fi_r'];
				$novo_intervalo[$it]['FacR'] = $FacR;
			}
		}

		$this->mapa_intervalo = $novo_intervalo; // adiciona o mapa da tabela de distribuição de frequências no atributo da classe
		return $this->mapa_intervalo; // Retorna o mapa
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