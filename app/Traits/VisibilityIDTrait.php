<?php

namespace App\Traits;

use App\Enums\Visibility;
use App\Models\Scopes\VisibilityIDScope;

/**
 * Trait VisibilityTrait
 *
 * Prioritize using this package where the visibility is an id, rather than the
 * old one with a string.
 *
 * @package App\Traits
 *
 * @property string|int|Visibility|null $visibility_id
 */
trait VisibilityIDTrait
{
    protected bool $skipAllIcon = false;
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootVisibilityIDTrait()
    {
        static::addGlobalScope(new VisibilityIDScope());
    }

    public function skipAllIcon(): self
    {
        $this->skipAllIcon = true;
        return $this;
    }

    /**
     * Generate the html icon for visibility
     * @param string|null $extra
     * @return string
     */
    public function visibilityIcon(string $extra = null): string
    {
        $class = $title = '';
        if ($this->visibility_id === Visibility::All) {
            if ($this->skipAllIcon) {
                return '';
            }
            $class = 'fa-solid fa-eye';
            $title = __('crud.visibilities.all');
        } elseif ($this->visibility_id === Visibility::Admin) {
            $class = 'fa-solid fa-lock';
            $title = __('crud.visibilities.admin');
        } elseif ($this->visibility_id === Visibility::Self) {
            $class = 'fa-solid fa-user-secret';
            $title = __('crud.visibilities.self');
        } elseif ($this->visibility_id === Visibility::AdminSelf) {
            $class = 'fa-solid fa-user-lock';
            $title = __('crud.visibilities.admin-self');
        } elseif ($this->visibility_id === Visibility::Member) {
            $class = 'fa-solid fa-users';
            $title = __('crud.visibilities.members');
        }

        return '<i class="' . rtrim($class . ' ' . $extra) . '" title="' . $title . '" data-toggle="tooltip" aria-hiden="true"></i>';
    }

    /**
     * Get a list of visibility options when editing an element
     * @return array
     */
    public function visibilityOptions(): array
    {
        $options = [];
        $options[Visibility::All->value] = __('crud.visibilities.all');

        if (auth()->user()->isAdmin()) {
            $options[Visibility::Admin->value] = __('crud.visibilities.admin');
            $options[Visibility::Member->value] = __('crud.visibilities.members');
        }
        if ($this->isCreator()) {
            $options[Visibility::Self->value] = __('crud.visibilities.self');
            $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');
        }

        // If it's a visibility self & admin, and we're not the creator, we can't change this
        if ($this->visibility_id === Visibility::AdminSelf && !$this->isCreator()) {
            $options = [Visibility::AdminSelf->value => __('crud.visibilities.admin-self')];
        } elseif ($this->visibility_id === Visibility::Self && !$this->isCreator()) {
            $options = [Visibility::Self->value => __('crud.visibilities.self')];
        }

        return $options;
    }

    /**
     * Determine if the current user is the creator
     * @return bool
     */
    protected function isCreator(): bool
    {
        return $this->created_by == auth()->user()->id;
    }
}
