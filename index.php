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
					<a class="navbar-brand text-light" href="#">Solicitações Clínicas</a>
				</button>
				<button type="button" class="btn btn-outline border border-light p-3">
					<a class="navbar-brand text-light" href="#">Listagem de Solicitações</a>
				</button>
			</div>
		</div>
	</nav>
</section>

<section class="solicitacoes container mt-5">

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
		<tr>
			<form>
				<th scope="row">Ellen Camila Klen</th>
				<td>10/08/2001</td>
				<td>659.295.950-97</td>
				<td>
					<button type="button" class="btn btn-warning text-light fs-5">Prosseguir</button>
				</td>
			</form>
		</tr>
		</tbody>
	</table>
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
