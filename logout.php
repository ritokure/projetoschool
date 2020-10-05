<?php
	// Código base pra eliminar completamente a Sessão e todos os seus dados, e depois voltar pra página principal.
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
	echo("<script>window.location.href = 'index.php';</script>");
?>