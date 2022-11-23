SELECT
    id, data_atendimento, `status`, preco, valor_comissao, logradouro, numero, cep,
    cliente_id, diarista_id, created_at
	FROM ediaristas_temp.diarias;
