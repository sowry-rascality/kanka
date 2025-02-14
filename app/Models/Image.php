<?php

namespace App\Models;

use App\Facades\Img;
use App\Models\Concerns\LastSync;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibilityIDTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Image
 * @package App\Models
 *
 * @property string $id
 * @property int $campaign_id
 * @property string $name
 * @property string $ext
 * @property int $size
 * @property int $created_by
 * @property ?int $focus_x
 * @property ?int $focus_y
 * @property string $folder_id
 * @property bool $is_default
 * @property bool $is_folder
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Image $imageFolder
 *
 * @property User $user
 * @property Campaign $campaign
 * @property Image[] $folders
 * @property Image[] $images
 * @property Entity[] $entities
 * @property Entity[] $headers
 *
 *
 * @property int $visibility_id
 * @property Visibility $visibility
 *
 * @property string $path
 * @property string $file
 * @property string $folder
 *
 *
 * @property int $_usageCount
 *
 * @method static Builder|self acl(bool $browse)
 */
class Image extends Model
{
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use LastSync;
    use VisibilityIDTrait;

    public $fillable = [
        'name',
        'is_folder',
        'folder_id',
        'visibility_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function imageFolder()
    {
        return $this->belongsTo(Image::class, 'folder_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'folder_id', 'id');
    }

    public function folders()
    {
        return $this->hasMany(Image::class, 'folder_id', 'id')
            ->where('is_folder', true);
    }

    public function entities()
    {
        return $this->hasMany(Entity::class, 'image_uuid', 'id');
    }

    public function headers()
    {
        return $this->hasMany(Entity::class, 'header_uuid', 'id');
    }

    public function visibility()
    {
        return $this->belongsTo(Visibility::class);
    }

    public function mentions()
    {
        return $this->hasMany(ImageMention::class, 'image_id', 'id');
    }

    public function inEntities(): array
    {
        $entities = [];
        foreach ($this->entities as $entity) {
            if (isset($entities[$entity->id])) {
                continue;
            }
            $entities[$entity->id] = $entity;
        }
        foreach ($this->headers as $entity) {
            if (isset($entities[$entity->id])) {
                continue;
            }
            $entities[$entity->id] = $entity;
        }

        return $entities;
    }

    public function inEntitiesCount(): int
    {
        if (isset($this->_usageCount)) {
            return $this->_usageCount;
        }

        return $this->_usageCount = count($this->inEntities());
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     */
    public function getPathAttribute(): string
    {
        return $this->folder . '/' . $this->file;
    }

    /**
     */
    public function getFileAttribute(): string
    {
        return $this->id . '.' . $this->ext;
    }

    /**
     */
    public function getFolderAttribute(): string
    {
        return 'campaigns/' . $this->campaign_id;
    }

    /**
     */
    public function niceSize(): string
    {
        if ($this->size > 1000) {
            return round($this->size / 1024, 2) . ' MB';
        }

        return $this->size . ' KB';
    }

    /**
     */
    public function scopeImageFolder(Builder $query, string $folderUuid = null): Builder
    {
        if (empty($folderUuid)) {
            return $query->whereNull('folder_id');
        }

        return $query->where('folder_id', $folderUuid);
    }

    /**
     */
    public function scopeDefaultOrder(Builder $query): Builder
    {
        return $query
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->orderBy('name', 'asc')
        ;
    }

    /**
     */
    public function scopeFolders(Builder $query): Builder
    {
        return $query
            ->where('is_folder', true)
            ->orderBy('name', 'asc');
    }

    public function scopeAcl(Builder $query, bool $browse): Builder
    {
        if (!$browse) {
            return $query->where('created_by', auth()->user()->id);
        }
        return $query;
    }

    /**
     */
    public function hasNoFolders(): bool
    {
        return $this->images()->where('is_folder', '1')->count() == 0;
    }

    /**
     */
    public function getImagePath($width = 40, $height = 40): string
    {
        return Img::resetCrop()->crop($width, $height)->url($this->path);
    }

    public function isFolder(): bool
    {
        return (bool) $this->is_folder;
    }

    public function isFont(): bool
    {
        return in_array($this->ext, ['woff', 'woff2']);
    }

    public function getUrl(int $sizeX = null, int $sizeY = null): string
    {
        Img::reset();

        if (!$sizeY && $sizeX) {
            $sizeY = $sizeX;
        } elseif (!$sizeX && $sizeY) {
            $sizeX = $sizeY;
        }
        if ($sizeX && $sizeY) {
            if (!$this->focus_x && !$this->focus_y) {
                return Img::crop($sizeX, $sizeY)->url($this->path);
            }
            return Img::focus($this->focus_x, $this->focus_y)->crop($sizeX, $sizeY)->url($this->path);
        }

        if ($this->focus_x && $this->focus_y) {
            return Img::focus($this->focus_x, $this->focus_y)->url($this->path);
        }

        return Img::url($this->path);
    }

    public function url(): string
    {
        $path = $this->path;
        $cloudfront = config('filesystems.disks.cloudfront.url');
        if ($cloudfront) {
            return Storage::disk('cloudfront')->url($path);
        }
        return Storage::url($path);
    }
}
