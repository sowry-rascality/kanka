<?php

namespace App\Observers;

use App\Models\MenuLink;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class TaggableObserver
{
    /**
     * @param Model $model
     */
    public function saved(Model $model)
    {
        $this->saveTags($model);
    }

    /**
     * @param Model $model
     * @return void
     */
    protected function saveTags(Model $model)
    {
        /** @var MenuLink $model */
        if (!request()->has('save_tags')) {
            return;
        }

        // Only save tags if we are in a form.
        $ids = request()->post('tags', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($model->tags as $tag) {
            $existing[$tag->id] = $tag->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                /** @var Tag $tag */
                $tag = Tag::findOrFail($id);
                $new[] = $tag->id;
            }
        }
        $model->tags()->attach($new);

        // Detach the remaining
        if (!empty($existing)) {
            $model->tags()->detach(array_keys($existing));
        }
    }
}
