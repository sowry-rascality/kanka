<?php

namespace App\Datagrids\Filters;

use App\Models\Creature;

class CreatureFilter extends DatagridFilter
{
    /**
     * Filters available for races
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'creature_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('creatures.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Creature::class,
            ])
            ->location()
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections()
        ;
    }
}
