<?php

	include_once ("modelo.php");

	function rotas($url) {

		$dados = explode("/", $url);

		// CADASTRAR
		if(strcmp($dados[0], "cadastrar") == 0) {
			echo "<script> window.location='viewCadastrar.php' </script>";
		}
		// ALTERAR
		else if(strcmp($dados[0], "alterar") == 0) {
			// Obtem dados do curso escolhido para alteração
			$pessoa = select_where(trim($dados[1]));

			if($pessoa == null) {
				echo "<script> alert('CPF da pessoa NÃO ENCONTRADO!') </script>";
			}
			else {		
				$url = "viewAlterar.php?cpf=".trim($dados[1])."&nome=".$pessoa[0]."&endereço=".$pessoa[1]."&telefone=".trim($pessoa[2]);
				echo "<script> window.location='".$url."' </script>";
			}
		}
		// REMOVER
		else if(strcmp($dados[0], "remover") == 0){
			delete($dados[1]);
		}
	}

	function cadastrar() {

		// Monta o array
		$dados = array(
			$_POST['cpf'] => array(
				"nome" => $_POST['nome'],
				"endereço" => $_POST['endereço'],
				"telefone" => $_POST['telefone']
			)
		);

		insert($dados);
		echo "<script> window.location='viewMain.php' </script>";
	}

	function alterar() {

		// Monta o array
		$dados = array(
			$_POST['cpf'] => array(
				"nome" => $_POST['nome'],
				"endereço" => $_POST['endereço'],
				"telefone" => $_POST['telefone']
			)
		);

		update($dados, $_POST['cpf']);
		echo "<script> window.location='viewMain.php' </script>";
	}

	

	function loadPessoas() {

		$pessoas = select();

		foreach ($pessoas as $cpf => $dados) {

			if(!empty($dados)) {
				echo "<tr>";
					echo "<td class='d-none d-md-table-cell'>".$cpf."</td>";

					$cont = 0;
					foreach ($dados as $valor) {
						if($cont == 0)
							echo "<td>".$valor."</td>";
						else 
							echo "<td class='d-none d-md-table-cell'>".$valor."</td>";
						
						$cont++;
					}

					echo "<td>";
						echo "<button type='submit' name='acao' value='alterar/".$cpf."' class='btn btn-success'>";
							echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>";
							echo "<path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>"; 
						echo "</svg>";
								
			
							
						echo "</button>";
						echo "&nbsp";
						echo "<button type='submit' name='acao' value='remover/".$cpf."' class='btn btn-danger'>";
							echo "<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='#FFF' class='bi bi-trash-fill' viewBox='0 0 16 16'>";
								echo "<path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>";
							echo "</svg>";
						echo "</button>";
					echo "</td>";
				echo "</tr>";
			}
		}
	}
?>
