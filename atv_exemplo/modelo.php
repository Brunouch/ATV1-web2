<?php

	function select() {

		$pessoas = array();
		$fp = fopen('pessoas.txt', 'r');

        if($fp) {
            while(!feof($fp)) {
				$arr = array();
                $id = fgets($fp);
				$dados = fgets($fp);
				if(!empty($dados)) {
					$arr = explode("#", $dados);
					$cursos[$id] = $arr;
				}
			}
			fclose($fp);
		}

		return $pessoas;
	}

	function select_where($cpf) {

		$pessoas = select();

		foreach ($pessoas as $chave => $dados) {
			// echo "$cpf=$chave<br>";
			if(strcmp($cpf, trim($chave)) == 0) { 
				return $dados;
			}
		}

		return null;	
	}

	function insert($pessoas) {

		$fp = fopen('pessoas.txt', 'a+');

		if ($fp) {
			foreach($pessoas as $cpf => $dados) {
				if(!empty($dados)) {
					fputs($fp, $cpf);
					fputs($fp, "\n");
					$linha=$dados['nome']."#".$dados['endereço']."#".$dados['telefone'];
					fputs($fp, $linha);
					fputs($fp, "\n");
				}
			}
			fclose($fp);
			echo "<script> alert('[OK] Pessoa Cadastrada com Sucesso!') </script>";
		}
	}

	function update($new, $cpf) {

		$pessoas = select();

		$fp = fopen('bkp.txt', 'a+');

		if ($fp) {
			foreach($pessoas as $chave => $dados) {
				if(!empty($dados)) {
					fputs($fp, $chave);
					if($cpf == trim($chave)){
						foreach($new as $new_cpf => $new_dados) {
							if(!empty($new_dados)) {
								$linha=$new_dados['nome']."#".$new_dados['endereço']."#".$new_dados['telefone']."\n";
							}
						}
					}
					else 
						$linha=$dados[0]."#".$dados[1]."#".$dados[2];
					fputs($fp, $linha);
				}
			}
			fclose($fp);
			echo "<script> alert('[OK] Pessoa Alterado com Sucesso!') </script>";

			unlink("pessoas.txt");
			rename("bkp.txt", "pessoas.txt");
		}
	}

	function delete() {
		
	}

?>
