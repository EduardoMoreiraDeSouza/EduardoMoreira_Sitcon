<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Teste Sitcon</title>
	<meta charset="UTF-8">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
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
				<a class="navbar-brand" href="./index.php">
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

	if (!isset($_GET['id']) or empty($_GET['id'])) {

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
				$execucaoQuery = $query -> ExecutarQueryMysql(
					"SELECT * FROM teste_sitcon.pacientes WHERE nome LIKE '%$pesquisa%' OR cpf LIKE '%$pesquisa%';"
				);
			}
			else
				$execucaoQuery = $query -> ExecutarQueryMysql("SELECT * FROM teste_sitcon.pacientes");

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
							<button type="submit" class="btn text-light fs-5" name="id" style="background-color: #ff8200"
							        value="<?= $dados['id'] ?>">
								Prosseguir
							</button>
						</form>
					</td style="background-color: <?= $cor ?>;">
				</tr>

				<?php
				$contador++;
			}
			?>

			</tbody>
		</table>

		<?php
	}
	else {
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

			<div class="container botao-voltar">
				<a class="navbar-brand" href="./index.php">
					<button type="button" class="btn btn-outline-primary">Voltar</button>
				</a>
			</div>

			<form class="container descricao-solicitacao" action="./back_end/solicitacoes/AlterarSolicitacoes.php"
			      method="POST">

				<div class="row">
					<div class="col">
						<label for="nomePaciente">Nome do Paciente:</label>
						<input type="text" class="form-control" id="nomePaciente" name="nomePaciente"
						       placeholder="Nome do Paciente"
						       value="<?= $dadosPaciente['nome'] ?>" disabled>
					</div>
					<div class="col">
						<label for="dataNasc">Data de Nascimento:</label>
						<input type="text" class="form-control" id="dataNasc" name="dataNasc"
						       placeholder="Data de Nascimento"
						       value="<?= $data -> format('d/m/Y') ?>" disabled>
					</div>
					<div class="col">
						<label for="cpf">CPF:</label>
						<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF"
						       value="<?= FormatarCPF ::FormatarCPF($dadosPaciente['cpf']) ?>" disabled>
					</div>
				</div>

				<div class="row mt-4">
					<div class="alert alert-warning" role="alert">
						<b>Atenção!</b> Os campos com <b>*</b> devem ser preenchidos obrigatóriamente.
					</div>
				</div>

				<div class="row">

					<div class="col-12">
						<label for="profissional">Profissional*</label>
						<select class="form-control" id="profissional" name="profissional" required>
							<option value="">Selecione</option>
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
						<select class="form-control" id="tipoSolicitacao" name="tipoSolicitacao" required>
							<option value="" id="vazio_tipoSolicitacao">Selecione</option>
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
						<select class="form-control" id="procedimentos" name="procedimentos" required>
							<option value="" id="vazio_procedimentos">Selecione</option>
							<?php

							$execucaoQuery = $query -> ExecutarQueryMysql(
								"SELECT * FROM teste_sitcon.procedimentos WHERE status LIKE 'ativo';"
							);
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