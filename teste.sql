SELECT
    id, data_atendimento, `status`, preco, valor_comissao,
    cliente_id, diarista_id, servico_id
    FROM ediaristas_temp.diarias
	WHERE id = 9;
