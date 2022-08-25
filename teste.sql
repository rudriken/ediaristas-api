INSERT INTO ediaristas_temp.servicos
    (
        `id`, `nome`, `valor_minimo`, `qtd_horas`, `porcentagem_comissao`,
        `horas_quarto`, `valor_quarto`, `horas_sala`, `valor_sala`,
        `horas_banheiro`, `valor_banheiro`, `horas_cozinha`, `valor_cozinha`,
        `horas_quintal`, `valor_quintal`, `horas_outros`, `valor_outros`,
        `icone`, `posicao`
    )
    VALUES
    (
        '1', 'Limpeza Comum', '50', '3', '10',
        '1', '11', '1', '10',
        '1', '12', '2', '15',
        '1', '12', '2', '16',
        '1', '1'
    ),
    (
        '2', 'Limpeza Pesada', '70', '3', '15',
        '1', '15', '1', '13',
        '2', '16', '2', '20',
        '1', '16', '3', '16',
        '2', '2'
    ),
    (
        '3', 'Limpeza Pós Obra', '90', '4', '20',
        '2', '20', '2', '16',
        '2', '20', '2', '22',
        '2', '17', '3', '20',
        '3', '3'
    );
