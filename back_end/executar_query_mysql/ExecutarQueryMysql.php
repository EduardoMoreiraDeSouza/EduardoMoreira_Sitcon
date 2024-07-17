<?php

require_once __DIR__ . "/../conexao_banco_dados/ConexaoBancoDados.php";

class ExecutarQueryMysql extends ConexaoBancoDados
{
	public function ExecutarQueryMysql($sql)
	{
		try {
			return mysqli_query($this -> ConexaoBancoDados(), $sql);
		} catch (Exception $e) {
			print "Erro ao executar query MySql";
			return false;
		}
	}
}