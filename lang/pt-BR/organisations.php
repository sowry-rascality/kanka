<?php

return [
    'create'        => [
        'title' => 'Nova Organização',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Extinta',
        'members'       => 'Membros',
    ],
    'helpers'       => [
        'descendants'       => 'Esta lista contém todas organizações que descendem desta organização, e não apenas aquelas diretamente relacionadas a ela.',
        'nested_without'    => 'Exibindo todas as organizações que não tem uma organização primária. Clique em uma linha para ver as organizações secundárias.',
    ],
    'hints'         => [
        'is_defunct'    => 'Esta organização está extinta.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'       => 'Adicionar um membro',
            'submit'    => 'Adicionar membro',
        ],
        'create'        => [
            'success'   => 'Membro adicionado à organização.',
            'title'     => 'Novo Membro',
        ],
        'destroy'       => [
            'success'   => 'Membro removido da organização.',
        ],
        'edit'          => [
            'success'   => 'Membro da organização atualizado.',
            'title'     => 'Atualizar Membro para :name',
        ],
        'fields'        => [
            'parent'    => 'Superior',
            'pinned'    => 'Fixado',
            'role'      => 'Função',
            'status'    => 'Status de Afiliação',
        ],
        'helpers'       => [
            'all_members'   => 'Todos personagens que são membros desta organização e suas sub-organizações.',
            'members'       => 'Todos personagens que são membros desta organização.',
            'pinned'        => 'Escolha se este membro deve ser exibido na seção fixada da visão geral de suas entidades associadas.',
        ],
        'pinned'        => [
            'both'  => 'Ambos',
            'none'  => 'Nenhum',
        ],
        'placeholders'  => [
            'parent'    => 'Quem é o superior desse membro',
            'role'      => 'Líder, Membro, Alto Septão, Mestre em Espionagem',
        ],
        'status'        => [
            'active'    => 'Membro ativo',
            'inactive'  => 'Membro inativo',
            'unknown'   => 'Status desconhecido',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Culto, Gangue, Rebelião, Fanáticos',
    ],
    'show'          => [],
];
