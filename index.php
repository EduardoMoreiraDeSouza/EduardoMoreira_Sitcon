<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Teste Sitcon</title>
	<meta charset="UTF-8">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<!-- CSS -->
	<link href="./estilos/estilos.css" rel="stylesheet">

</head>
<body>

<section class="menu position-fixed">
	<nav class="navbar navbar-primary fixed-top bg-primary">
		<div class="container row">
			<div class="col">
				<button type="button" class="btn btn-outline border border-light p-3">
					<a class="navbar-brand text-light" href="./index.php">Solicitações Clínicas</a>
				</button>
			</div>
		</div>
	</nav>
</section>

<section class="solicitacoes container mt-5">

	<?php

	require(__DIR__ . "/./back_end/executar_query_mysql/ExecutarQueryMysql.php");
	require(__DIR__ . "/./back_end/formatacao/FormatarCPF.php");
	$query = new ExecutarQueryMysql();

	if (!isset($_GET['id']) or empty($_GET['id'])) {

		?>

		<form class="form pesquisa-solicitacoes mb-5 mt-5">
			<input class="form-control border-black" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
		</form>

		<table class="table table-striped table-primary text-center tabela-solicitacoes">
			<thead>
			<tr>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Paciente</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Nascimento</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">CPF</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Ações</th>
			</tr>
			</thead>
			<tbody>

			<?php
			$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes");
			while ($dados = mysqli_fetch_assoc($execucaoQuery)) {
				$data = DateTime ::createFromFormat('Y-m-d', $dados['dataNasc']);
				?>

				<tr>
					<th scope="row"><?= $dados['nome'] ?></th>
					<td><?= $data -> format('d/m/Y') ?></td>
					<td><?= FormatarCPF ::FormatarCPF($dados['cpf']) ?></td>
					<td>
						<form method="GET">
							<button type="submit" class="btn btn-warning text-light fs-5" name="id"
							        value="<?= $dados['id'] ?>">
								Prosseguir
							</button>
						</form>
					</td>
				</tr>

				<?php
			}
			?>

			</tbody>
		</table>

		<?php
	}
	else {
		require(__DIR__ . "/./back_end/executar_query_mysql/AntiInjecaoMysql.php");
		$id = AntiInjecaoMysql ::AntiInjecaoMysql($_GET['id']);
		$execucaoQuery = $query -> ExecutarQueryMysql(
			"SELECT * FROM teste_sitcon.pacientes WHERE id LIKE '" . $_GET['id'] . "';"
		);
		$dadosPaciente = mysqli_fetch_assoc($execucaoQuery);

		if (!$dadosPaciente or empty($dadosPaciente)) {
			print "<h3>Paciente Não Encontrado!</h3>";
		}
		else {
			$data = DateTime ::createFromFormat('Y-m-d', $dadosPaciente['dataNasc']);
			?>

			<form class="container descricao-solicitacao">
				<div class="row">
					<div class="col">
						<label for="nomePaciente">Nome do Paciente:</label>
						<input type="text" class="form-control" id="nomePaciente" placeholder="Nome do Paciente"
						       value="<?= $dadosPaciente['nome'] ?>" disabled>
					</div>
					<div class="col">
						<label for="dataNasc">Data de Nascimento:</label>
						<input type="text" class="form-control" id="dataNasc" placeholder="Data de Nascimento"
						       value="<?= $data -> format('d/m/Y') ?>" disabled>
					</div>
					<div class="col">
						<label for="cpf">CPF:</label>
						<input type="text" class="form-control" id="cpf" placeholder="CPF"
						       value="<?= FormatarCPF ::FormatarCPF($dadosPaciente['cpf']) ?>" disabled>
					</div>
				</div>
				<div class="row mt-4">
					<div class="alert alert-warning" role="alert">
						<b>Atenção!</b> Os campos com <b>*</b> são de preenchimento obrigatório!
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label for="profissional">Profissional*</label>
						<select class="form-control" id="profissional" required>
							<option>Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql(
								"SELECT * FROM teste_sitcon.profissional WHERE status LIKE 'ativo';"
							);
							while ($profissionais = mysqli_fetch_assoc($execucaoQuery)) {
								$nome = $profissionais['nome'];
								$id = $profissionais['id'];
								print "<option value='$id'>$nome</option>";
							}

							?>
						</select>
					</div>
					<div class="col-6 mt-4">
						<label for="tipoSolicitacao">Tipo de Solicitação*</label>
						<select class="form-control" id="tipoSolicitacao" required>
							<option>Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql(
								"SELECT * FROM teste_sitcon.tiposolicitacao WHERE status LIKE 'ativo';"
							);
							while ($tipoSolicitacao = mysqli_fetch_assoc($execucaoQuery)) {
								$descricao = $tipoSolicitacao['descricao'];
								$id = $tipoSolicitacao['id'];
								print "<option value='$id'>$descricao</option>";
							}

							?>
						</select>
					</div>
					<div class="col-6 mt-4">
						<label for="procedimentos">Procedimentos*</label>
						<select class="form-control" id="procedimentos" required>
							<option>Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql(
								"SELECT * FROM teste_sitcon.procedimentos WHERE status LIKE 'ativo';"
							);
							while ($procedimentos = mysqli_fetch_assoc($execucaoQuery)) {
								$descricao = $procedimentos['descricao'];
								$id = $procedimentos['id'];
								$idTipo = $procedimentos['tipoSolicitacao_id'];
								print "<option value='$id|$idTipo'>$descricao</option>";
							}

							?>
						</select>
					</div>
					<div class="col-6 mt-4">
						<label for="data">Data*</label>
						<input type="date" id="data" class="form-control" required>
					</div>
					<div class="col-6 mt-4">
						<label for="hora">Hora*</label>
						<input type="time" id="hora" class="form-control" required>
					</div>
				</div>
				<button type="submit" class="btn btn-primary mt-4">Salvar</button>
			</form>

			<?php
		}
	}

	?>

</section>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>
</html>