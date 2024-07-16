<?php

class AntiInjecaoMysql
{
	static function AntiInjecaoMysql($dados) {

		$codigosMySql = [
			'select ',
			' from ',
			' or ',
			' like ',
			' and ',
			'delete',
			'drop',
			'update',
			'database',
			';'
		];

		$contador = 0;
		foreach ($codigosMySql as $ignored) {
			$dados = str_replace($codigosMySql[$contador], '', $dados);
			$contador++;
		}

		return $dados;
	}
}