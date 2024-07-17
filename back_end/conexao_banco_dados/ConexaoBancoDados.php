<?php

class ConexaoBancoDados
{
	public function ConexaoBancoDados()
	{
		try {
			return mysqli_connect(
				'localhost',
				'root',
				'',
				'teste_sitcon',
				'3306'
			);
		} catch (Exception $e) {
			print "Houve um erro ao conectar com o servidor MySQL";
			return false;
		}
	}
}