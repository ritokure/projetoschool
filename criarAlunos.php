
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php
			include("include/head.php");
			
			include("include/requerLogin.php");
		?>
	</head>
	
	<body>

	<?php
		include("include/cabecalho.php");
	?>



	<main role="main" class="container">
		<div class="div-corpoConteudo">
			
			
		<div class="col-md-12">
			<h4 class="mb-3">Cadastrar um novo aluno</h4>
			<form class="needs-validation" method="post" action="criarAlunos.php">
				<div class="row">
					<div class="col-md-8 mb-3">
						<label for="NomeAluno">Nome</label>
						<input type="text" class="form-control" id="NomeAluno" name="NomeAluno" value="" required>
						<div class="invalid-feedback">
						  Escreva um nome válido.
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label for="SexoAluno">Sexo</label>
						<select class="custom-select d-block w-100" id="SexoAluno" name="SexoAluno" required>
						  <option value="F">Feminino</option>
						  <option value="M">Masculino</option>
						</select>
					</div>
				</div>

				<!-- Para cadastrar uma data, telefone ou outra informação com uma estrutura especifica,
					 é comum fazer uso de Máscaras pra garantir que a informação foi escrita corretamente. -->
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="DataNasc">Data de Nascimento</label>
						<input type="text" class="form-control" id="DataNasc" name="DataNasc" placeholder="Formato DD/MM/AAAA" value="" required>
						<div class="invalid-feedback">
							Coloque uma data válida.
						</div>
					</div>

				</div>

				<hr class="mb-4">
				<button class="btn btn-primary btn-lg btn-block" type="submit">Cadastrar</button>
			</form>
		</div>
		
		
		</div>
	</main>
	</body>
	
	<!-- Aqui vamos verificar se foram reenviadas informações dessa página para ela mesma. O funcionamento é igual
		 ao da página Login, mas ao invés de fazer uma verificação via SELECT, faremos uma inserção via INSERT -->
	<?php
	
		// Validação pra ver se existe alguma informação enviada via POST. Porém, dessa vez, teremos que fazer uma verificação
		// mais precisa dos dados recebidos - afinal, pesquisar por dados errados não tem problemas, já que não vai dar resultado,
		// mas tentar inserir dados errados podem causar problemas ao Banco de Dados.
			if ( (empty($_POST["NomeAluno"]) == false)
				AND
			 (empty($_POST["DataNasc"]) == false) ) {
			

			$nome	 	= $_POST["NomeAluno"];
			$sexo		= $_POST["SexoAluno"];
			$dataNasc	= $_POST["DataNasc"];
			
			
			
			// Pra validar o que foi escrito vamos seguir alguns princípios básicos: Nenhum nome completo vai ter menos que 4 caracteres,
			// a data de nascimento no formato DD/MM/AAAA vai ter 10 caracteres. O nº de caracteres é contado com a função "strlen"
			if ( (strlen($nome) >= 4)
				AND
			   (strlen($dataNasc) >= 10) ) {
				   
				include("conexao.php");
				
				
				// Uma coisa muito importante que precisamos fazer antes da inserção é tratar a data. Bancos de Dados trabalham dias
				// no sistema internacional AAAA-MM-DD, então precisamos "fatiar" a data que a pessoa escreveu em pedaços
				// usando a função "substr" e depois refazer a data, colocando tudo na ordem certa em uma nova variável.
				$diaFatiado = 	substr($dataNasc,0,2);
				$mesFatiado = 	substr($dataNasc,3,2);
				$anoFatiado = 	substr($dataNasc,6,4);
				$dataNovo = $anoFatiado . "-" . $mesFatiado . "-" . $diaFatiado;
				
				
				// Note o uso da função "Addslashes" aqui, seu propósito é prevenir que símbolos especiais que podem atrapalhar
				// o funcionamento do SQL, intencionalmente inseridos ou não, acabem travando o sistema, ou pior.
				// Ao fazer sistemas online, medidas de prevenção como essa são muito importantes, e é sempre recomendado que
				// você dê uma pesquisada no que é uma "Injeção SQL", como é feita e como um desenvolvedor previne ela.
				// Também note que não precisamos necessariamente jogar o resultado dessa query Insert em uma variável como o SELECT.
				mysqli_query($conexaoBD, "INSERT INTO alunos (ALU_NOME, ALU_DATNAS, ALU_SEXO) VALUES
								('".addslashes($nome)."', '".addslashes($dataNovo)."', '".addslashes($sexo)."');");
				
				
				// Fecha a conexão.
				mysqli_close($conexaoBD);

				   
			   }
			
			echo("<script>window.location.href = 'listaAlunos.php';</script>");
		}
	
	?>
</html>
