<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Teste Sitcon</title>
	<meta charset="UTF-8">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

	<!-- CSS -->
	<link href="./estilos/estilos.css" rel="stylesheet">

</head>
<body>

<section class="menu position-absolute fixed-top">
	<nav class="navbar navbar-primary fixed-top bg-primary">
		<div class="container text-end">
			<div class="col">
				<a class="navbar-brand" href="./index.php">
					<button type="button" class="btn btn-outline border border-light p-3 text-light">
						Solicitações Clínicas
					</button>
				</a>
				<a class="navbar-brand" href="./index.php?listagemSolicitacoes=true">
					<button type="button" class="btn btn-outline border border-light p-3 text-light">
						Listagem de Solicitações
					</button>
				</a>
			</div>
		</div>
	</nav>
</section>

<section class="solicitacoes container mt-5">

	<?php

	require(__DIR__ . "/./back_end/executar_query_mysql/ExecutarQueryMysql.php");
	require(__DIR__ . "/./back_end/formatacao/FormatarCPF.php");
	require(__DIR__ . "/./back_end/executar_query_mysql/AntiInjecaoMysql.php");

	$query = new ExecutarQueryMysql();

	if (isset($_GET['paginacao']) and !empty($_GET['paginacao']))
		$paginacao = AntiInjecaoMysql ::AntiInjecaoMysql($_GET['paginacao']) * 10;
	else
		$paginacao = 0;

	if (!isset($_GET['id']) and !isset($_GET['listagemSolicitacoes']) and !isset($_GET['pesquisa_lista'])) {

		?>

		<form class="form pesquisa-solicitacoes mb-5 mt-5" method="GET">
			<div class="input-group">
				<span class="input-group-addon">
					<label for="pesquisa"><i class="fa fa-search"></i></label>
				</span>
				<input class="form-control border-black" type="search" placeholder="Pesquisar" id="pesquisa"
				       name="pesquisa">
			</div>
		</form>

		<table class="table text-center tabela-solicitacoes">
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

			if (isset($_GET['pesquisa']) and !empty($_GET['pesquisa'])) {
				$pesquisa = AntiInjecaoMysql ::AntiInjecaoMysql(($_GET['pesquisa']));
				$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes WHERE nome LIKE '%$pesquisa%' OR cpf LIKE '%$pesquisa%' LIMIT 10 OFFSET $paginacao;");
				$quantidadePacientes = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT COUNT(*) FROM teste_sitcon.pacientes WHERE nome LIKE '%$pesquisa%' OR cpf LIKE '%$pesquisa%';"))['COUNT(*)'];
			}

			else {
				$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes LIMIT 10 OFFSET $paginacao;");
				$quantidadePacientes = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT COUNT(*) FROM teste_sitcon.pacientes;"))['COUNT(*)'];
			}

			$contador = 0;
			while ($dados = mysqli_fetch_assoc($execucaoQuery)) {
				$data = DateTime ::createFromFormat('Y-m-d', $dados['dataNasc']);
				$cor = $contador % 2 == 0 ? '#fafafa' : '#e7f4f9';
				?>

				<tr>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $dados['nome'] ?></th>
					<td style="background-color: <?= $cor ?>;"><?= $data -> format('d/m/Y') ?></td>
					<td style="background-color: <?= $cor ?>;"><?= FormatarCPF ::FormatarCPF($dados['cpf']) ?></td>
					<td style="background-color: <?= $cor ?>;">
						<form method="GET">
							<button type="submit" class="btn text-light fs-5" name="id"
							        style="background-color: #ff8200" value="<?= $dados['id'] ?>">Prosseguir
							</button>
						</form>
					</td style="background-color: <?= $cor ?>;">
				</tr>

			<?php $contador++; } ?>

			</tbody>
		</table>

		<nav class="d-flex justify-content-center">
			<ul class="pagination">
				<?php

				$quantidadePaginas = ceil($quantidadePacientes / 10);
				$contador = 0;

				for ($i = 0; $i < $quantidadePaginas; $i++) { ?>
					<li class="page-item"><a class="page-link" href="?paginacao=<?= $i ?>"><?= $i + 1 ?></a></li>
				<?php } ?>

			</ul>
		</nav>

		<?php
	}

	elseif (isset($_GET['listagemSolicitacoes']) and !empty($_GET['listagemSolicitacoes']) or isset($_GET['pesquisa_lista']) and !empty($_GET['pesquisa_lista'])) {

		?>

		<form class="form pesquisa-solicitacoes mb-5 mt-5" method="GET">
			<div class="input-group">
				<span class="input-group-addon">
					<label for="pesquisa"><i class="fa fa-search"></i></label>
				</span>
				<input class="form-control border-black" type="search" placeholder="Pesquisar" id="pesquisa" name="pesquisa_lista">
			</div>
		</form>

		<table class="table text-center tabela-solicitacoes tabela-listagem mt-5">
			<thead>
			<tr>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Paciente</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">CPF</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Tipo de Solicitação</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Procedimentos</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Data</th>
				<th scope="col" class="bg-primary text-light fs-4 p-4">Hora</th>
			</tr>
			</thead>
			<tbody>

			<?php

			if (isset($_GET['pesquisa_lista']) and !empty($_GET['pesquisa_lista'])) {

				$pesquisa = AntiInjecaoMysql ::AntiInjecaoMysql(($_GET['pesquisa_lista']));

				$execucaoQuery = $query -> ExecutarQueryMysql(
					"SELECT * FROM teste_sitcon.solicitacoes
						    LEFT JOIN pacientes on solicitacoes.id_paciente = pacientes.id
						    LEFT JOIN procedimentos on solicitacoes.id_procedimento = procedimentos.id
						    LEFT JOIN tipoSolicitacao on solicitacoes.id_tipoSolicitacao = tipoSolicitacao.id
						WHERE nome LIKE '%$pesquisa%' OR cpf LIKE '%$pesquisa%' or procedimentos.descricao LIKE '%$pesquisa%' or tipoSolicitacao.descricao LIKE '%$pesquisa%' LIMIT 10 OFFSET 0;");

				$quantidadeSolicitacoes = mysqli_fetch_assoc(
					$query -> ExecutarQueryMysql(
						"SELECT COUNT(*) FROM teste_sitcon.solicitacoes
						    LEFT JOIN pacientes on solicitacoes.id_paciente = pacientes.id
						    LEFT JOIN procedimentos on solicitacoes.id_procedimento = procedimentos.id
						    LEFT JOIN tipoSolicitacao on solicitacoes.id_tipoSolicitacao = tipoSolicitacao.id
						WHERE nome LIKE '%$pesquisa%' OR cpf LIKE '%$pesquisa%' or procedimentos.descricao LIKE '%$pesquisa%' or tipoSolicitacao.descricao LIKE '%$pesquisa%';"
					))['COUNT(*)'];
			}

			else {
				$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.solicitacoes LIMIT 10 OFFSET $paginacao;");
				$quantidadeSolicitacoes = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT COUNT(*) FROM teste_sitcon.solicitacoes;"))['COUNT(*)'];
			}

			$contador = 0;
			while ($dados = mysqli_fetch_assoc($execucaoQuery)) {

				$cor = $contador % 2 == 0 ? '#fafafa' : '#e7f4f9';
				$nomePaciente = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes WHERE id LIKE '" . $dados['id_paciente'] . "';"))['nome'];
				$cpf = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes WHERE id LIKE '" . $dados['id_paciente'] . "';"))['cpf'];
				$tipoSolicitacao = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.tipoSolicitacao WHERE id LIKE '" . $dados['id_tipoSolicitacao'] . "';"))['descricao'];
				$procedimentos = mysqli_fetch_assoc($query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.procedimentos WHERE id LIKE '" . $dados['id_procedimento'] . "';"))['descricao'];
				$data = DateTime ::createFromFormat('Y-m-d', $dados['dataProcedimento']);

				?>

				<tr>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $nomePaciente ?></th>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= FormatarCPF ::FormatarCPF($cpf) ?></th>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $tipoSolicitacao ?></th>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $procedimentos ?></th>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $data -> format('d/m/Y') ?></th>
					<th scope="row" style="background-color: <?= $cor ?>;"><?= $dados['horaProcedimento'] ?></th>
				</tr>

				<?php $contador++;
			} ?>

			</tbody>
		</table>

		<nav class="d-flex justify-content-center">
			<ul class="pagination">
				<?php
				$quantidadePaginas = ceil($quantidadeSolicitacoes / 10);
				for ($i = 0; $i < $quantidadePaginas; $i++) { ?>
					<li class="page-item"><a class="page-link" href="?listagemSolicitacoes=true&paginacao=<?= $i ?>"><?= $i + 1 ?></a>
					</li>
				<?php } ?>
			</ul>
		</nav>

		<?php

	}

	else {

		$id = AntiInjecaoMysql ::AntiInjecaoMysql($_GET['id']);
		$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes WHERE id LIKE '" . $_GET['id'] . "';");
		$dadosPaciente = mysqli_fetch_assoc($execucaoQuery);

		if (!$dadosPaciente or empty($dadosPaciente))
			print "<h3>Paciente Não Encontrado!</h3>";

		else { ?>

			<div class="container botao-voltar">
				<a class="navbar-brand" href="./index.php">
					<button type="button" class="btn btn-outline-primary">Voltar</button>
				</a>
			</div>

			<form class="container descricao-solicitacao" action="./back_end/solicitacoes/AlterarSolicitacoes.php" method="POST">

				<div class="row">
					<div class="col">
						<label for="nomePaciente">Nome do Paciente:</label>
						<input type="text" class="form-control" id="nomePaciente" name="nomePaciente" placeholder="Nome do Paciente" value="<?= $dadosPaciente['nome'] ?>" readonly>
					</div>
					<div class="col">
						<label for="dataNasc">Data de Nascimento:</label>
						<input type="date" class="form-control" id="dataNasc" name="dataNasc" placeholder="Data de Nascimento" value="<?= $dadosPaciente['dataNasc'] ?>" readonly>
					</div>
					<div class="col">
						<label for="cpf">CPF:</label>
						<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?= FormatarCPF ::FormatarCPF($dadosPaciente['cpf']) ?>" readonly>
					</div>
				</div>

				<div class="row mt-4">
					<div class="alert alerta" role="alert">
						<b>Atenção!</b> Os campos com <b>*</b> devem ser preenchidos obrigatóriamente.
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<label for="profissional">Profissional*</label>
						<select class="form-control" id="profissional" name="profissional" required>
							<option value="">Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.profissional WHERE status LIKE 'ativo';");

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
						<select class="form-control" id="tipoSolicitacao" name="tipoSolicitacao" required>
							<option value="" id="vazio_tipoSolicitacao">Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.tipoSolicitacao WHERE status LIKE 'ativo';");
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
						<select class="form-control" id="procedimentos" name="procedimentos" required>
							<option value="" id="vazio_procedimentos">Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.procedimentos WHERE status LIKE 'ativo';");
							while ($procedimentos = mysqli_fetch_assoc($execucaoQuery)) {
								$descricao = $procedimentos['descricao'];
								$id = $procedimentos['id'];
								print "<option value='$id' id='$id'>$descricao</option>";
							}

							?>
						</select>
					</div>

					<div class="col-6 mt-4">
						<label for="data">Data*</label>
						<input type="date" id="data" name="data" class="form-control" required>
					</div>

					<div class="col-6 mt-4">
						<label for="hora">Hora*</label>
						<input type="time" id="hora" name="hora" class="form-control" required>
					</div>

				</div>

				<div class="col-12 botao-salvar">
					<button type="submit" class="btn btn-primary mt-4">Salvar</button>
				</div>

			</form>

			<?php
		}
	}

	?>

</section>

<footer class="rodape">
	<div class="container-fluid py-3">
		<div class="row">
			<div class="col-12 text-center"><p class="mb-0">Eduardo_Moreira_SITCON</p></div>
		</div>
	</div>
</footer>

<!-- JS -->
<script>

    let profissionalAtende = [];
    let tipoSolicitacaoProcedimento = [];

	<?php
	$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.profissionalatende WHERE status LIKE 'ativo';");

	while ($profissionalAtende = mysqli_fetch_assoc($execucaoQuery)) { ?>
        profissionalAtende.push('<?= $profissionalAtende['profissional_id'] ?> atende <?= $profissionalAtende['procedimento_id'] ?>');
	<?php }

	$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.procedimentos WHERE status LIKE 'ativo';");

	while ($procedimentos = mysqli_fetch_assoc($execucaoQuery)) { ?>
        tipoSolicitacaoProcedimento.push('<?= $procedimentos['id'] ?> procedimento <?= $procedimentos['tipoSolicitacao_id'] ?>');
	<?php } ?>

</script>

<script src="./js/javaScript.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>