<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Human\Models\HumanUnit As Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfrastructureUnit extends Model
{
    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-unit'];

    public function assets(): HasMany
    {
        return $this->hasMany(InfrastructureAsset::class, 'unit_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InfrastructureDocument::class, 'unit_id');
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function mapResourceShow(Request $request, $model = null) : array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
        ];
    }

    public static function refCombos() : array
    {
        // temporary
        $human = InfrastructureUnit::get(['id','name','slug']);

        // notes : assign units into properties
        $units = [];
        $ids = [];

        $names = [];
        $slugs = [];

        // notes : mapping to the array so frontend can consume..
        foreach ($human as $key => $value) {
            array_push( $names, $value->name );
            array_push( $slugs, $value->slug );
            array_push( $units, $value );
            $ids[$value->id] = $value;
        }

        return [
            'units' => $units,
            'ids' => $ids,
            'names' => $names,
            'slugs' => $slugs,
        ];
    }

}
