<?php
// Nesse arquivo vamos realizar a conexão com um Banco de Dados via o comando "mysqli_conenct"
// 	*	Ao usar o servidor de testes Xampp, o Servidor e o Cliente são os mesmos (isso é, o mesmo PC),
//		por isso podemos usar o endereço "localhost" e o login "root".
//	*	Ao contratar um serviço de Servidor remoto tipo Hostinger, GoDaddy, etc. pra colocar ele no ar,
//		troque "localhost" pelo endereço do provedor e configure o login "root" e a senha (atual "")
//	*	Por último, "qualityschool" é o Banco de Dados que vamos estar utilizando.

// Como esse comando "mysqli_connect" precisa ser feito toda vez que quisermos usar o B.D.,
// é muito importante deixar ele em um comando externo, e fazer uma requisição dela via comando "include"
// Dessa forma, se precisarmos trocar de Servidor, não vamos precisar refazer o sistema inteiro!

// Sempre que quisermos acessar a conexão, vamos usar a variável "$conexaoBD" abaixo.
// Essa variável pode ter qualquer nome, mas é sempre recomendado usar um nome simples e fácil de lembrar.
$conexaoBD = mysqli_connect("localhost","root","","qualityschool");

// Verifica a conexão, e se der problema, cancela tudo e exibe mensagem de erro
if (mysqli_connect_errno()) {
  echo "Erro na conexão: " . mysqli_connect_error();
  exit();
}

// Aqui vamos trocar o padrão de teclado enviado pro B.D. para UTF8, que é o padrão internacional usado no Brasil.
// Também é possível trocar essa informação indo pras configurações do B.D., mas deixar tudo aqui é mais fácil!
mysqli_set_charset($conexaoBD,"utf8");


// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !! NÃO SE ESQUEÇA DE DESCONECTAR DO BANCO DEPOIS DE USAR USANDO mysqli_close !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!




?> 