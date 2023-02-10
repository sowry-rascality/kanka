<?php

namespace App\Http\Resources;

use App\Models\EntityEvent;

class EntityEventResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityEvent $model */
        $model = $this->resource;
        return $this->entity([
            'calendar_id' => $model->calendar_id,
            'date' => $model->date(),
            'day' => $model->day,
            'month' => $model->month,
            'year' => $model->year,
            'length' => $model->length,
            'comment' => $model->comment,
            'is_recurring' => (bool) $model->is_recurring,
            'recurring_until' => $model->recurring_until,
            'recurring_until_month' => $model->recurring_until_month,
            'recurring_until_day' => $model->recurring_until_day,
            'recurring_periodicity' => $model->recurring_periodicity,
            'colour' => $model->colour,
            'type_id' => $model->type_id,
            'visibility_id' => $model->visibility_id,
            'created_by' => $model->created_by,
        ]);
    }
}
