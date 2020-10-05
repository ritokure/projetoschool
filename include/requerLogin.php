<?php

	// Aqui temos um arquivo simples: Ele verifica se você está logado (se você tem uma variável de Sessão válida)
	// e se você não tiver, significa que você não tem acesso a essa página e será redirecionado a página principal.
	// Pode parecer redundante, afinal os botões que levam as outras páginas só aparecem se você estiver logado,
	// mas como qualquer pessoa pode acessar o histórico de um usuário e "pular" o acesso via botões, é bom garantir.
	
	if ( !isset( $_SESSION['usuarioLogado'] ) OR ( $_SESSION['usuarioLogado'] == "" ) ) {
		echo("<script>window.location.href = 'index.php';</script>");
	}

?>