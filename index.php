<!DOCTYPE html>
<html>
<head>
	<title>Trabalho de estatística</title>
	<link type="text/css" rel="stylesheet" href="entrada.css">
</head>
<body>
	<header>
		<div class="content">
			Estatística Aplicada a Computação
		</div>
	</header>

	<div class="container">
		<div class="content">
			<form method="post" action="apresentacao.php">
				
				<label for="sequencia_dados">
					<span>Sequência de dados</span><br />
					<small>Digite todos os dados separando por ";" (ponto e vírgula).</small>
				</label>

				<textarea id="sequencia_dados" name="sequencia_dados" placeholder="Exemplo: 5.1;10.3;15.5;20.7;25.9"></textarea>

				<div class="buttons">
					<input type="submit" value="Calcular" />
				</div>
			</form>
		</div>
	</div>
</body>
</html>