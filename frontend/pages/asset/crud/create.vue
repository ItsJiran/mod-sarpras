<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos: { type_key, units, units_slug, type_status_map },
			record,
			store,
		 }">
			<v-card-text>
				
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Assets"
						v-model="record.asset_type_key"
						:return-object="false"
						@update:model-value="selectAssetsType(record, type_status_map, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row v-if="$router.currentRoute._value.name == 'infrastructure-asset-create'" dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Unit"
							v-model="unit.name"
							:readonly="true"					
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="units_slug" 
						label="Pilih Unit"
						v-model="record.slug_unit"
						@update:model-value="selectUnit(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if=" unit.name != undefined && currentFormType != '' " dense>
					<v-col cols="12">
						<v-combobox
						:items="type_status_map[currentFormType]" 
						:return-object="false"
						label="Status Asset"
						v-model="record.status"			
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					v-if=" $router.currentRoute._value.name != 'infrastructure-asset-create' || unit.name != undefined && currentFormType != '' "
					:record="record"
					:is="currentFormType"/>					
		
			</v-card-text>
		</template>
	</form-create>
</template>

<script>

// assets type form
import Land from "./create-part/create-land";
import Electronic from "./create-part/create-electronic";
import Furniture from "./create-part/create-furniture";
import Vehicle from "./create-part/create-vehicle";

export default {
	name: "infrastructure-asset-create",

	components : {
		Land,
		Electronic,
		Furniture,
		Vehicle,
	},

	data(){
		return {
			currentFormType:"",
			formType: [
				'Vehicle',
                'Furniture',
                'Electronic',
                'Land', 
			],
			unit: {}
		}
	},

	methods : {
		selectUnit : (record, units, data) => {			
			data.unit = units[record.slug_unit];
		},
		selectAssetsType : (record, status_map, data) => {
			data.currentFormType = record.asset_type_key;
			record.status = status_map[record.asset_type_key][0];
		}
	},
};
</script>
