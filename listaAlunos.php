
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
			<h1>Lista de Alunos</h1>
			<p class="painelLista">
				<a href="criarAlunos.php">
					<button type="button" class="btn btn-primary"><b>+</b> Novo Aluno</button>
				</a>
			</p>
			

				
				<table class="table table-hover table-dark tabelaListagem">
					<thead>
					<tr>
						<th scope="col">Cod.</th>
						<th scope="col">Nome</th>
						<th scope="col">Idade</th>
						<th scope="col">Ações</th>
					</tr>
					</thead>
					<tbody style="padding:2px;">
					<?php
						// Aqui vamos fazer uma consulta para listar todos os Alunos do Banco de Dados.
						// Da mesma forma que o Login, vamos começar com um "include" para puxar o código de conexão,
						// seguido de um "mysqli_query" pra fazer a consulta via uma linha de comando SELECT,
						// tratar os dados usando um WHILE pra percorrer os resultados de "mysqli_fetch_array"
						// e finalizar fechando o banco com "mysqli_close"
						include("conexao.php");
						
						// Consulta simples para correr todos os alunos. Idealmente, estaríamos já tratando essa consulta pra limitar o nº de alunos
						// e evitar que a gente acabe sobrecarregando o servidor puxando milhares de alunos de uma só vez, mas vamos começar simples.
						// Note porém que ao invés de puxar a Data de Nascimento do banco, estamos puxando o resultado de um DATEDIFF, uma função SQL
						// usada pra descobrir a diferença entre 2 datas e que vamos usar pra obter a Idade do aluno.
						$queryBD = mysqli_query($conexaoBD, "SELECT ALU_CODIGO, ALU_NOME, DATEDIFF(NOW(), `ALU_DATNAS`) AS ALU_IDADE, ALU_SEXO FROM alunos;");
						
						// Diferente do Login, aqui esperamos vários resultados, um pra cada aluno, então não se esqueça:
						// O que está aqui dentro acontece uma vez pra cada resultado encontrado no B.D.
						while( $linha = mysqli_fetch_array($queryBD) ) {
							
							echo "<tr>";
							
							// Vamos montar aqui a tabela, uma linha por ciclo do While, como se estivéssemos escrevendo HTML.
							// A diferença é que vamos usar $linha[] pra puxar dados do B.D. e colocar informações dentro da tabela.
							echo '<th scope="row">'.$linha["ALU_CODIGO"].'</th>';
							
							
							// Aqui vou fazer algo diferente, ao invés de escrever "Masculino" ou "Feminino" pra cada Aluno, vou demonstrar
							// visualmente o sexo por meio de uma esfera colorida. Por questões de acessibilidade, idealmente
							// iríamos usar icones pra isso, como os disponíveis na biblioteca "FontAwesome", mas faremos isso mais tarde.
							if ($linha["ALU_SEXO"] == "M") {
								// Vamos definir uma cor a ser usada mais tarde como um tom de Azul
								$corIcone = "color:#59E";
							} else {
								// ...mas se o Sexo não for "M", vamos definir um tom de Rosa no lugar
								$corIcone = "color:#E9A";
							}
							// Vamos usar esse corIcone acima pra definir a cor de um texto dinamicamente usando PHP
							// pra gerar tags HTML com CSS. "&bull;" é o código Ascii pra aquela bolinha usada em lista.
							echo '<td><a style="'.$corIcone.'"> &bull; </a> '.$linha["ALU_NOME"].'</td>';
							
							
							// Vamos dividir a diferença em dias vinda do SQL por 365 e depois arredondar, pra transformar em anos. Essa forma
							// de calcular idade não é perfeita (não considera bissextos e portanto tem uma pequena margem de erro) mas é o suficiente.
							$idadeCalculada = floor($linha["ALU_IDADE"] / 365);
							echo '<td>'.$idadeCalculada.'</td>';
							
							
							// Aqui colocaremos botões pra alterar 
							echo '<td></td>';
							
							
							echo "</tr>";
						}
						
						// Sempre feche a conexão depois que terminar de usar
						mysqli_close($conexaoBD);
					
					?>
					</tbody>
				</table>
				

		</div>

		</main>
	</body>
</html>
