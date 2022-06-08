<?php

	include_once 'global.php';
    include_once 'Pessoa.php';

	class PessoaController {

		public static function index() {
			echo "<script>window.location='viewMain.php'</script>";
		}

		public static function rotas() {

			// echo "<script>alert('cadastrar')</script>";
			$dados = explode("/", $_POST['acao']);

            if(strcmp($dados[0], "cadastrar") == 0) {
				self::create();
            }
			else if(strcmp($dados[0], "alterar") == 0) {
				self::edit($dados[1]);
			}
			else if(strcmp($dados[0], "remover") == 0) {
				self::destroy($dados[1]);
			}
		}

		public static function create() {
            echo "<script>window.location='viewCadastrar.php'</script>";
        }

		public static function store() {

			$data = array(
				"nome" => $_POST["nome"],
                "cpf" => $_POST["cpf"],
				"endereco" => $_POST["endereco"],
				"telefone" => $_POST["telefone"]
			);

			Pessoa::create($data);
			echo "<script>window.location='viewMain.php'</script>";
		}

		public static function edit($cpf) {

			$pessoa = Pessoa::find($cpf);

			if(!empty($pessoa)) {

				$url = "viewAlterar.php?cpf=$pessoa->cpf";
                $url .= "&nome=$pessoa->nome";
                $url .= "&endereco=$pessoa->endereco";
                $url .= "&telefone=$pessoa->telefone";

				echo "<script>window.location='". $url ."'</script>";
			}
		}

		public static function update() {
			
			$data = array(
				"nome" => $_POST["nome"],
				"endereco" => $_POST["endereco"],
				"telefone" => $_POST["telefone"]
			);

			Pessoa::update($_POST["cpf"], $data);
			echo "<script>window.location='viewMain.php'</script>";
		}

		public static function destroy($cpf) {
			Pessoa::destroy($cpf);
			echo "<script>window.location='viewMain.php'</script>";
		}

		public static function loadTable() {

			$data = Pessoa::all("ORDER BY nome");

			while($row = $data->fetchObject()) {

				echo "<tr>";
					echo "<td class='d-none d-md-table-cell'>".$row->cpf."</td>";
					echo "<td>".$row->nome."</td>";
					echo "<td class='d-none d-md-table-cell'>".$row->endereco."</td>";
					echo "<td class='d-none d-md-table-cell'>".$row->telefone."</td>";
					echo "<td>";
						echo "<button type='submit' name='acao' value='alterar/".$row->cpf."' class='btn btn-success'>";
							echo "<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='#FFF' class='bi bi-arrow-counterclockwise' viewBox='0 0 16 16'>";
								echo "<path fill-rule='evenodd' d='M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z'/>";
								echo "<path d='M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z'/>";
							echo "</svg>";
						echo "</button>";
						echo "&nbsp";
						echo "<button type='submit' name='acao' value='remover/".$row->cpf."' class='btn btn-danger'>";
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