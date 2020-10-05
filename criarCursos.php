
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
			<h4 class="mb-3">Cadastrar um novo curso</h4>
			<form class="needs-validation" method="post" action="criarCursos.php">
				<div class="row">
					<div class="col-md-8 mb-3">
						<label for="NomeCurso">Descrição</label>
						<input type="text" class="form-control" id="NomeCurso" name="NomeCurso" value="" required>
						<div class="invalid-feedback">
						  Escreva uma descrição válida.
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label for="HorasCurso">Carga Horária Total</label>
						<input type="text" class="form-control" id="HorasCurso" name="HorasCurso" placeholder="Tempo em horas" required>
						<div class="invalid-feedback">
						  Escreva uma carga horária válida.
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="SemanasCurso">Carga Horária (semanas)</label>
						<input type="text" class="form-control" id="SemanasCurso" name="SemanasCurso" required>
						<div class="invalid-feedback">
							Escreva o nº de semanas do curso.
						</div>
					</div>
				
					<div class="col-md-6 mb-3">
						<label for="ValorCurso">Valor Total do Curso</label>
						<input type="text" class="form-control" id="ValorCurso" name="ValorCurso" required>
						<div class="invalid-feedback">
							Escreva o valor do curso (em R$)
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
	
			if ( (empty($_POST["NomeCurso"]) == false) ) {
			

			$nome	 	= $_POST["NomeCurso"];
			$horas		= $_POST["HorasCurso"];
			$semanas	= $_POST["SemanasCurso"];
			$valor		= $_POST["ValorCurso"];
			
			include("conexao.php");			
			
			mysqli_query($conexaoBD, "INSERT INTO cursos (CUR_DESCRI, CUR_QTDHOR, CUR_QTDSEM, CUR_VALTOT) VALUES
						('".addslashes($nome)."', ".addslashes($horas).", ".addslashes($semanas).", ".addslashes($valor).");");
			
			
			// Fecha a conexão.
			mysqli_close($conexaoBD);

			   
		
			echo("<script>window.location.href = 'listaCursosAlunos.php';</script>");
		}
	
	?>
</html>
