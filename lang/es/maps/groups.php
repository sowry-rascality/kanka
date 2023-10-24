<?php

return [
    'actions'       => [
        'add'   => 'Añadir nuevo grupo',
    ],
    'bulks'         => [
        'delete'    => '{1} Se ha eliminado :count grupo.|[2,*] Se han eliminado :count grupos.',
        'patch'     => '{1} Se ha actualizado :count grupo.|[2,*] Se han actualizado :count grupos.',
    ],
    'create'        => [
        'success'   => 'Grupo :name creado.',
        'title'     => 'Nuevo grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo :name eliminado.',
    ],
    'edit'          => [
        'success'   => 'Grupo :name actualizado.',
        'title'     => 'Editar grupo :name',
    ],
    'fields'        => [
        'is_shown'  => 'Mostrar marcadores del grupo',
        'position'  => 'Posición',
    ],
    'helper'        => [
        'amount_v3' => 'Los marcadores pueden agruparse utilizando grupos de mapas. Al explorar un mapa, se puede hacer clic en cada grupo para mostrar u ocultar rápidamente todos los marcadores que contiene.',
    ],
    'hints'         => [
        'is_shown'  => 'Si está seleccionado, los marcadores del grupo se mostrarán en el mapa por defecto.',
    ],
    'index'         => [
        'title' => 'Grupos de :name',
    ],
    'pitch'         => [
        'error' => 'Número máximo de grupos alcanzado.',
        'until' => 'Crea hasta :max grupos para cada mapa.',
    ],
    'placeholders'  => [
        'name'          => 'Tiendas, tesoros, PNJs...',
        'position'      => 'Campo opcional para indicar el orden en el que aparecen los grupos.',
        'position_list' => 'Después de :name',
    ],
    'reorder'       => [
        'save'      => 'Guardar nuevo orden',
        'success'   => '{1} Se ha reordenado :count grupo.|[2,*] Se han reordenado :count grupos.',
        'title'     => 'Reordenar grupos',
    ],
];
