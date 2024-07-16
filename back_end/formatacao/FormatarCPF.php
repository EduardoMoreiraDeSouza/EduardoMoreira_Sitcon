<?php

class FormatarCPF
{
	static function FormatarCPF($cpf)
	{
		return substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);
	}
}