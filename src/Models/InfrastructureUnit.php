<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Human\Models\HumanUnit As Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureMaintenance;

class InfrastructureUnit extends Model
{
    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-unit'];


    /**
     * ====================================================
     * +------------------ MAP RELATION ------------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function assets(): HasMany
    {
        return $this->hasMany(InfrastructureAsset::class, 'unit_id');
    }
    
    /**
     * Get the model that the image belongs to.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(InfrastructureDocument::class, 'unit_id');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function maintenances_assets()
    {
        return InfrastructureMaintenanceAsset::where('unit_id',$this->id)
        ->join('infrastructure_maintenances','infrastructure_maintenances.id','=','infrastructure_maintenance_assets.maintenance_id');                
    }

    /**
     * Get the model that the image belongs to.
     */
    public function maintenances_documents()
    {
        return InfrastructureMaintenanceDocuments::where('unit_id',$this->id)
        ->join('infrastructure_maintenances','infrastructure_maintenances.id','=','infrastructure_maintenance_documents.maintenance_id');                
    }

    /**
     * ====================================================
     * +------------------ MAP RESOURCE ------------------+
     * ====================================================
     */

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
