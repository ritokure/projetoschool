
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
			<h1>Gerenciar Cursos</h1>
			
			<p class="painelLista">
				<a href="criarCursos.php">
					<button type="button" class="btn btn-primary"><b>+</b> Novo Curso</button>
				</a>
			</p>
			
			<?php
				// Aqui vamos fazer uma página contendo todos os cursos, com opções que abrem para exibir 
				// os alunos associados. Existem duas formas de fazer isso: Com consultas relacionais (SELECT com JOIN)
				// ou com consultas incrementais (fazendo duas consultas SELECT em separado, em duas queries separadas).
				// Apesar da primeira opção ser tecnicamente mais eficiente, a segunda tem uma grande vantagem:
				// Não precisamos fazer as duas consultas de uma vez. Isso é muito bom, pois com uso inteligente de
				// programação, podemos evitar a pesquisa de dados desnecessários do B.D. que sobrecarregariam o servidor.			
				
				include("conexao.php");
				$queryBD = mysqli_query($conexaoBD, "SELECT CUR_CODIGO, CUR_DESCRI, CUR_VALTOT FROM cursos;");
				while( $linha = mysqli_fetch_array($queryBD) ) {
					
					echo '<p class="selecaoLista">';
					// Note que esse link é especial: ele utiliza o código encontrado do Curso dentro dele depois do "?".
					// Isso permite que o PHP consiga ler variáveis direto do link via $_GET, útil porque ai conseguimos
					// criar uma única página que acessa diferentes informações baseado no encontrado na Variável.
					// Nesse caso a ideia é que, se encontrada essa variável (porque a pessoa clicou nesse Link) vamos
					// procurar os Alunos desse curso e montar nesse mesmo While uma segunda consulta incremental.
					echo '<a href="listaCursosAlunos.php?curso='.$linha["CUR_CODIGO"].'">';
					echo $linha["CUR_DESCRI"] . ' - Valor Total: R$' . $linha["CUR_VALTOT"];
					echo '</a>';
					echo '</p>';
					
					
					// Se o valor do GET encontrado é o do Curso atual, significa que o usuário clicou no Curso e portanto
					// vamos fazer uma Query para encontrar quais os alunos dentro do Curso.
					if ( isset($_GET["curso"]) ) {
						
						$cursoGet = $_GET["curso"];
						if ( $cursoGet == $linha["CUR_CODIGO"] ) {
							
							// Aqui vamos fazer uma verificação do POST, para ver se o usuário quer inserir um novo Aluno nesse curso.
							// Para entender melhor como foi feito isso, veja abaixo no Include do Modal e na págna "modalGetAluno.php"
							// Precisamos fazer isso antes de gerar a lista de Alunos, porque senão o novo aluno não irá aparecer.
							if ( isset($_POST["modalAluno"]) && $_POST["modalAluno"] != "" ) {
								
								// Aqui faremos uma consulta incremental, uma consulta dentro de outra consulta While, para verificar se
								// o aluno escolhido já existe dentro desse curso. Note que nesse caso não precisamos das informações,
								// somente ver se esse registro já existe, portanto vamos usar o COUNT pra contar o nº de ocorrências.
								$queryBD2 = mysqli_query($conexaoBD, "SELECT COUNT(*) AS ALU_ENCONTRADOS FROM alunos_cursos
																	WHERE CAL_CODCUR = ".$cursoGet." AND CAL_CODALU = ".$_POST["modalAluno"]);
								while( $linha2 = mysqli_fetch_array($queryBD2) ) {
									
									// Se não foi encontrada nenhuma ocorrência desse aluno nesse curso, inserir ele no curso.
									if ( $linha2["ALU_ENCONTRADOS"] == 0 ) {
									
										mysqli_query($conexaoBD, "INSERT INTO alunos_cursos (CAL_CODALU, CAL_CODCUR) VALUES
												(".addslashes($_POST["modalAluno"]).", '".addslashes($cursoGet)."');");
										
									}
									
								}
							}
							
							
							echo '<table class="table table-hover table-dark tabelaListagem">';
							echo '<tbody style="padding:2px;text-align:left;">';
							
							
							// Outra consulta incremental pros alunos que estão conectados ao Curso por meio da tabela "alunos_cursos".
							// Note que as variáveis "linha" e "queryBD" ainda estão sendo utilizadas no While da consulta
							// acima, então é importante não alterar elas se quisermos continuar rodando o While acima. 
							$queryBD2 = mysqli_query($conexaoBD, "SELECT ALU_CODIGO, ALU_NOME, ALU_SEXO, DATEDIFF(NOW(), `ALU_DATNAS`) AS ALU_IDADE
														FROM alunos_cursos INNER JOIN alunos ON CAL_CODALU = ALU_CODIGO WHERE CAL_CODCUR = ".$cursoGet);
							while( $linha2 = mysqli_fetch_array($queryBD2) ) {
								
								// O código abaixo é quase idêntico ao da página "listaAlunos.php", o que muda é que usamos $linha2 e o SELECT acima.
								echo "<tr>";
								if ($linha2["ALU_SEXO"] == "M") {
									$corIcone = "color:#59E";
								} else {
									$corIcone = "color:#E9A";
								}
								echo '<td style="padding-left:20px"><a style="'.$corIcone.'"> &bull; </a> '.$linha2["ALU_NOME"].'</td>';
								$idadeCalculada = floor($linha2["ALU_IDADE"] / 365);
								echo '<td>'.$idadeCalculada.' anos</td>';
								
								
								// Aqui colocaremos botões pra alterar 
								echo '<td></td>';
								echo "</tr>";
																
							}
							
							echo '</tbody></table>';
							echo '<div style="text-align:right;margin-bottom:2rem;">';
							echo '<button type="button" class="btn btn-success" data-toggle="modal" href="#modalGetAluno">+ Aluno</button>';
							echo '</div>';
						}
					}
				}
				
				mysqli_close($conexaoBD);
			
			?>
				

		</div>
		<?php
			// Aqui vamos fazer a importação de um "Modal", uma pequena janela pop-up pra dar ao usuário a opção
			// de escolher um Aluno pro curso selecionado. Como o Modal só será relevante se a pessoa já escolheu
			// um curso, vamos fazer uma verificação a partir do GET explicado acima.
			if ( isset($_GET["curso"]) ) {
				// Vamos recolocar a informação do GET no Action, assim a pessoa pode continuar a trabalhar com o Curso.
				echo '<form method="post" action="listaCursosAlunos.php?curso='.$_GET["curso"].'">';
				include("include/modalGetAluno.php");
				echo '</form>';
			}
		?>
		</form>
		</main>
	</body>
</html>
