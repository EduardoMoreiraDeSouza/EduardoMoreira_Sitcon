<?php

require_once __DIR__ . "/../executar_query_mysql/ExecutarQueryMysql.php";
require_once __DIR__ . "/../executar_query_mysql/AntiInjecaoMysql.php";

class AlterarSolicitacoes extends ExecutarQueryMysql
{

	public function __construct()
	{

		$nomePaciente = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['nomePaciente']);
		$dataNasc = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['dataNasc']);
		$cpf = trim(preg_replace('/[^0-9]/', '', AntiInjecaoMysql ::AntiInjecaoMysql($_POST['cpf'])));

		$profissional = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['profissional']);
		$tipoSolicitacao = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['tipoSolicitacao']);
		$procedimentos = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['procedimentos']);
		$dataProcedimento = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['data']);
		$horaProcedimento = AntiInjecaoMysql ::AntiInjecaoMysql($_POST['hora']);

		$execucaoPacientes = $this -> ExecutarQueryMysql(
			"SELECT * FROM teste_sitcon.pacientes WHERE nome LIKE '$nomePaciente' AND dataNasc LIKE '$dataNasc' AND cpf LIKE '$cpf' AND status LIKE 'ativo';"
		);

		$dadosPaciente = mysqli_fetch_assoc($execucaoPacientes);
		if (empty($dadosPaciente)) {
			$this -> mensagem('O paciente não está cadastrado ou está inativo!');
			return false;
		}

		$execucaoProfissioanl = $this -> ExecutarQueryMysql(
			"SELECT * FROM teste_sitcon.profissional WHERE id LIKE '$profissional' AND status LIKE 'ativo';"
		);

		$dadosProfissional = mysqli_fetch_assoc($execucaoProfissioanl);
		if (empty($dadosProfissional)) {
			$this -> mensagem('O profissional não está cadastrado!');
			return false;
		}

		$execucaoTipoSolicitacao = $this -> ExecutarQueryMysql(
			"SELECT * FROM teste_sitcon.tiposolicitacao WHERE id LIKE '$tipoSolicitacao' AND status LIKE 'ativo';"
		);

		$dadosTipoSolicitacao = mysqli_fetch_assoc($execucaoTipoSolicitacao);
		if (empty($dadosTipoSolicitacao)) {
			$this -> mensagem('Não existe este tipo de solicitação no sistema!');
			return false;
		}

		$execucaoProcedimentos = $this -> ExecutarQueryMysql(
			"SELECT * FROM teste_sitcon.procedimentos WHERE id LIKE '$procedimentos' AND status LIKE 'ativo';"
		);

		$dadosProcedimentos = mysqli_fetch_assoc($execucaoProcedimentos);
		if (empty($dadosProcedimentos)) {
			$this -> mensagem('Não existe este procedimento no sistema!');
			return false;
		}

		if ($dadosProcedimentos['tipoSolicitacao_id'] == $dadosTipoSolicitacao['id']) {
			$execucaoProfissionalAtende = $this -> ExecutarQueryMysql(
				"SELECT * FROM teste_sitcon.profissionalatende WHERE status LIKE 'ativo' AND profissional_id LIKE '" . $dadosProfissional['id'] . "' AND procedimento_id LIKE '" . $dadosProcedimentos['id'] . "';;"
			);
			if (!$execucaoProfissionalAtende) {
				$this -> mensagem('Este profissional não atende este procedimento!');
				return false;
			}

			$selecionarSolicitacaoPaciente = $this -> ExecutarQueryMysql(
				"SELECT * FROM teste_sitcon.solicitacoes WHERE id_paciente LIKE '" . $dadosPaciente['id'] . "';"
			);
			if (empty(mysqli_fetch_assoc($selecionarSolicitacaoPaciente))) {
				$cadastrarSolicitacao = $this -> ExecutarQueryMysql(
				"INSERT INTO teste_sitcon.solicitacoes VALUES (
						'0', 
						'" . $dadosPaciente['id'] . "',
						'" . $dadosProfissional['id'] . "',
						'" . $dadosTipoSolicitacao['id'] . "',
						'" . $dadosProcedimentos['id'] . "',
						'" . $dataProcedimento . "',
						'" . $horaProcedimento . "'
	                );");

				if ($cadastrarSolicitacao) {
					$this -> mensagem('Solicitação criada com sucesso!');
					return true;
				}
				else {
					$this -> mensagem('Solicitação não foi criada!');
					return false;
				}
			}
			else {
				$atualizarSolicitacao = $this -> ExecutarQueryMysql(
					"UPDATE teste_sitcon.solicitacoes SET
						id_paciente = '" . $dadosPaciente['id'] . "',
						id_profissional = '" . $dadosProfissional['id'] . "',
						id_tipoSolicitacao = '" . $dadosTipoSolicitacao['id'] . "',
						id_procedimento = '" . $dadosProcedimentos['id'] . "',
						dataProcedimento = '" . $dataProcedimento . "',
						horaProcedimento = '" . $horaProcedimento . "'
						WHERE id_paciente LIKE '" . $dadosPaciente['id'] . ";';
					;");
				if ($atualizarSolicitacao) {
					$this -> mensagem('Solicitação atualizada com sucesso!');
					return true;
				}
				else {
					$this -> mensagem('Solicitação não foi atualizada!');
					return false;
				}
			}

		}

		$this -> mensagem('O procedimento não condiz com o tipo de solicitação!');
		return false;
	}

	public function mensagem($mensagem)
	{
		print "<script>alert('$mensagem')</script>";
		print "<script>window.location.href = `../../index.php`</script>";
	}
}

new AlterarSolicitacoes();