<?php

namespace App\Traits;

use Exception;

trait ExportableTrait
{
    /**
     * Prepares the data of an entity to json.
     * @throws Exception
     */
    public function export(): string
    {
        $json = $this->toArray();

        // Foreign attributes? character's traits and stuff
        if (property_exists($this, 'foreignExport')) {
            foreach ($this->foreignExport as $foreign) {
                $json[$foreign] = [];
                try {
                    foreach ($this->$foreign as $model) {
                        $json[$foreign][] = $model->toArray();
                    }
                } catch (Exception $e) {
                    throw new Exception("Unknown relation '{$foreign}' on model " . get_class($this));
                }
            }
        }

        // Entity values
        if (!empty($this->entity)) {
            // Todo: put these in with()
            $foreigns = ['posts', 'relationships', 'abilities', 'events', 'tags', 'assets', 'entityAttributes', 'image', 'header'];
            foreach ($foreigns as $foreign) {
                if (($foreign == 'image' || $foreign == 'header') && $this->entity->$foreign) {
                    $json[$foreign] = ['id' => $this->entity->$foreign->id, 'focus_x' =>  $this->entity->$foreign->focus_x, 'focus_y' =>  $this->entity->$foreign->focus_y];
                } elseif ($foreign != 'image' && $foreign != 'header') {
                    foreach ($this->entity->$foreign as $model) {
                        if (method_exists($model, 'exportFields')) {
                            $export = [];
                            foreach ($model->exportFields as $field) {
                                $export[$field] = $model->$field;
                            }
                            $json[$foreign][] = $export;
                        } else {
                            $json[$foreign][] = $model->toArray();
                        }
                    }
                }
            }
            /*$foreigns = ['attributes'];
            foreach ($foreigns as $foreign) {
                // Have to do the ()->get because of attributes being otherwise something else
                foreach ($this->entity->$foreign()->get() as $model) {
                    $json[$foreign][] = $model->toArray();
                }
            }*/
        }

        return json_encode($json);
    }
}
