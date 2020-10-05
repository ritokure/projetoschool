	<html>
		<head>
			<?php
				// Alterado o Head pra ser um arquivo externo, pra manter tudo padronizado e evitar repetição.
				// Note que esse Include feito assim não é ideal - ele só pode incluir Head se Head estiver na mesma pasta
				// Isso se resolve com certas técnicas PHP como as "Constantes Mágicas", mas isso já é PHP avançado
				include("include/head.php");
			?>
		</head>
		<body style="padding:5%;">
		
		<!-- (2) Uso de Div pra centralizar Login (código CSS incluso em arquivo externo "fundoAzul") -->
		<div class="text-center div-telaLogin">
			<!-- (2) Alteração na tag Form, para incluir o Action (aonde os dados do Form vão) -->
			<form method="post" action="login.php">
				<div class="form-group">
					<h3><label for="inputUsername"> Usuário </label></h2>
					<!-- (2) Campos no PHP são encontrados com Name, então é boa prática usar tanto ID quanto Name -->
					<input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Entre com o seu nome de usuário" name="username">
				</div>
				<div class="form-group">
					<h3><label for="inputPassword"> Senha </label></h2>
					<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre com a sua senha" name="password">
				</div>
				<button type="submit" class="btn btn-primary"> Entrar </button>
			</form>
		</div>
		</body>
		
	<!-- Vamos iniciar o PHP aqui. Geralmente é recomendado iniciar PHP ANTES da montagem da página,
		mas coloquei aqui pra ficar mais fácil pra acompanhar o fluxo dos dados -->
	<?php
	
		// A Página Login vai enviar pra ela mesma os dados do Formulário, portanto se recebermos o Login e Senha aqui via POST,
		// significa que o usuário preencheu os campos listados acima e podemos fazer uma verificação do usuário no SQL
		
		// Pegar os dados repassados em formulário é feito com a variável $_POST[''], com o nome do campo dentro dos colchetes
		// Mas antes de trabalhar as variáveis, vamos ver se realmente existe alguma postagem de formulário usando "empty()"
		if ( (empty($_POST["inputUsername"]) == false)
				AND
			 (empty($_POST["inputPassword"]) == false) ) {
			
			
			// Puxa os dados escritos pelo usuário, e coloca eles numa variável
			$usuario 	= $_POST["inputUsername"];
			$senha		= $_POST["inputPassword"];
			
			
			// Inclui o arquivo externo "conexao.php", que é um arquivo que vamos montar pra fazer todas as conexões com o B.D. no sistema
			include("conexao.php");
			
			// É sempre bom encriptar a senha do usuário antes de trabalhar com ela, e apesar do base64 não ser a melhor prática,
			// vamos utilizar esse comando por enquanto só pra "esconder" a senha do usuário no B.D.
			$senha		= base64_encode($senha);
			
			// Vamos agora enviar o comando SELECT pro banco de dados pra processar no B.D. usando o comando "mysqli_query"
			$queryBD = mysqli_query($conexaoBD, "SELECT USU_CODIGO, USU_CODFUN FROM usuarios WHERE USU_LOGIN = '".$usuario."' AND USU_SENHA = '".$senha."' LIMIT 1;");
			
			// Percorre a lista de resultados da consulta. O While acontece uma vez por resultado, e cada dado é obtido via $linha[].
			while( $linha = mysqli_fetch_array($queryBD) ) {
				
				// Se encontrar algum resultado, então o Login foi bem-sucedido e os dados do usuário são mantidos em uma "Sessão".
				$_SESSION['codigoLogado'] 	= $linha["USU_CODIGO"];
				$_SESSION['usuarioLogado']	= $usuario;
				echo("Logado!");
				
				// Aqui vamos usar o PHP pra gerar um código Javascript. É comum ter que fazer isso ao programar PHP, pois ele é Server-side,
				// e portanto tem certas coisas que o Servidor não consegue fazer no computador do Cliente. Por exemplo a linha seguinte é usada
				// pra levar o navegador pra página de Entrada. Como o navegador fica no lado "Cliente" do Cliente-Servidor, o PHP não faz isso
				echo("<script>window.location.href = 'index.php';</script>");
			
			}
			
			// Sempre feche a conexão depois que terminar de usar
			mysqli_close($conexaoBD);
		}
	
	?>
	
	
	
	</html>
	
