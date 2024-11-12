<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Human\Models\HumanUnit As Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureMaintenance;

use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Module\Infrastructure\Models\InfrastructureTaxDocument;
use Module\Infrastructure\Models\InfrastructureTax;

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

    public function assets(): HasMany
    {
        return $this->hasMany(InfrastructureAsset::class, 'unit_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InfrastructureDocument::class, 'unit_id');
    }

    public function maintenances_assets()
    {
        return InfrastructureMaintenanceAsset::where('unit_id',$this->id)
        ->join('infrastructure_maintenances','infrastructure_maintenances.id','=','infrastructure_maintenance_assets.maintenance_id');                
    }

    public function maintenances_documents()
    {
        return InfrastructureMaintenanceDocuments::where('unit_id',$this->id)
        ->join('infrastructure_maintenances','infrastructure_maintenances.id','=','infrastructure_maintenance_documents.maintenance_id');                
    }

    public function taxes_assets()
    {
        return InfrastructureTaxAsset::where('unit_id',$this->id)
        ->join('infrastructure_taxes','infrastructure_taxes.id','=','infrastructure_tax_assets.tax_id');                
    }


    public function taxes_documents()
    {
        return InfrastructureTaxDocuments::where('unit_id',$this->id)
        ->join('infrastructure_taxes','infrastructure_taxes.id','=','infrastructure_tax_documents.tax_id');                
    }

        /**
     * Get the model that the image belongs to.
     */
    public function taxes()
    {
        // return InfrastructureRecord::
        // join('infrastructure_records','infrastructure_records.targetable_id','=','infrastructure_assets.id')
        // ->join('infrastructure_units','infrastructure_records.targetable_id','=','infrastructure_assets.id')
        // ->where('infrastructure_records.targetable_type',self::class)
        // ->where('infrastructure_records.type','tax');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function maintenances()
    {
        // return InfrastructureRecord::
        // join('infrastructure_records','infrastructure_records.targetable_id','=','infrastructure_assets.id')
        // ->where('infrastructure_records.targetable_type',self::class)
        // ->where('infrastructure_records.type','maintenance');            
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
