<div class="modal" tabindex="-1" role="dialog" id="modalGetAluno">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Escolher Aluno</h5>
				<button type="button" class="close" data-dismiss="modal" style="color:#922">
					&times;
				</button>
			</div>
			<div class="modal-body">
				<p>
					<select name="modalAluno" id="modalAluno" class="form-control">
						<option value="">Selecione...</option>
					<?php
						// Aqui iremos fazer um Select simples que irá listar todos os Alunos do B.D. e colocar todos
						// em um Option (caixa que desce com opções). Note que não estamos usando a Tag Form, apesar de
						// Option ser campo de formulário. Isso porque se fizermos isso, o Modal sempre iria nos mandar
						// pra 1 página específica. Ao invés disso, iremos cercar o Include por Tags Form.
						include("conexao.php");
						$queryBD = mysqli_query($conexaoBD, "SELECT ALU_CODIGO, ALU_NOME FROM alunos;");
						while( $linha = mysqli_fetch_array($queryBD) ) {
							echo '<option value="'.$linha["ALU_CODIGO"].'">'.$linha["ALU_NOME"].'</option>';
						}
						mysqli_close($conexaoBD);
					?>
					</select>
				</p>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">OK</button>
			</div>
		</div>
	</div>
</div>