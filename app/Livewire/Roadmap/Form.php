<?php

namespace App\Livewire\Roadmap;

use App\Enums\FeatureStatus;
use App\Models\Feature;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    #[Validate('required|min:5')]
    public string $title = '';

    #[Validate('required|min:5')]
    public string $description = '';

    public bool $success = false;

    public $duplicates;

    public function save()
    {
        $this->authorize('create', Feature::class);
        $this->validate();

        $feat = new Feature();
        $feat->created_by = auth()->user()->id;
        $feat->name = $this->title;
        $feat->description = $this->description;
        $feat->status_id = FeatureStatus::Draft;
        $feat->save();

        $this->success = true;
        $this->title = '';
        $this->description = '';
    }

    public function updated()
    {
        if (empty($this->title)) {
            return;
        }

        $titles = explode(' ', $this->title);
        $words = [];
        $base = Feature::approved();
        foreach ($titles as $word) {
            // Let's try and skip small descriptive words
            if (mb_strlen($word) <= 4) {
                continue;
            }
            $words[] = $word;
        }
        if (empty($words)) {
            return;
        }
        $base->where(function ($sub) use ($words) {
            foreach ($words as $word) {
                $sub->orWhere('name', 'like', '%' . $word . '%');
            }
            return $sub;
        });

        $this->duplicates = $base->limit(5)->get();
    }

    public function open(Feature $feature)
    {
        $this->dispatch('open-idea', idea: $feature->id);
    }

    public function render()
    {
        return view('livewire.roadmap.form');
    }
}
