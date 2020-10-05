
<!DOCTYPE html>
<html lang="pt-br">
  <head>
	<?php
		// Alterado o Head pra ser um arquivo externo, pra manter tudo padronizado e evitar repetição.
		// Note que esse Include feito assim não é ideal - ele só pode incluir Head se Head estiver na mesma pasta
		// Isso se resolve com certas técnicas PHP como as "Constantes Mágicas", mas isso já é PHP avançado
		include("include/head.php");
	?>
  </head>
  <body>

	<div class="cover-container d-flex w-400 h-100 p-3 mx-auto flex-column">
	<header class="masthead mb-auto" style="min-width: 360px;">
	  <div class="inner">
		<nav class="nav nav-masthead justify-content-end">
		<?php
			// Verificação para checar se existe uma variável de Sessão pro Usuário. Se existir, o Usuário está logado
			// e vamos mostrar o nome aqui. Senão, vamos colocar na página o botão de Login que estava aqui antes.
			if ( isset( $_SESSION['usuarioLogado'] )
				AND
			   ( $_SESSION['usuarioLogado'] != "" ) ) {
				   echo "<a class='nav-link' href='logout.php#'>".$_SESSION['usuarioLogado']." - Logout</a>";
			   } else {
				   echo "<a class='nav-link' href='login.php#'>Login</a>";
			   }
		?>
		</nav>
	  </div>
	</header>

	<main role="main" class="inner cover">
	  <h1 class="cover-heading"><big><b>Projeto School</big></b></h1>
		<div class="div-listaOpcoes">
			<?php
				// Verificação para checar se existe uma variável de Sessão pro Usuário. Se existir, o Usuário está logado
				// e vamos mostrar o nome aqui. Senão, vamos colocar na página o botão de Login que estava aqui antes.
				if ( isset( $_SESSION['usuarioLogado'] )
					AND
				   ( $_SESSION['usuarioLogado'] != "" ) ) {
					   echo "<p><a href='listaAlunos.php'>Gerenciar Alunos</a></p>";
					   echo "<p><a href='listaCursosAlunos.php'>Gerenciar Cursos</a></p>";
				   }
			?>
		</div>
	</main>

	<footer class="mastfoot mt-auto">
		<div class="inner">
			<p>Prof. Felipe Millan, Microcamp Americana</p>
		</div>
	</footer>
	</div>

	</body>
</html>
