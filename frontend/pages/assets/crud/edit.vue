<template>
	<form-edit with-helpdesk>
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
						<v-text-field
							label="Slug"
							v-model="record.slug"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Assets"
						v-model="record.asset_type_key"
						:readonly="true"
						:return-object="false"
						@update:model-value="selectAssetsType(record, type_status_map, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Unit"
							v-model="record.unit_name"
							:readonly="true"					
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						label="Slug Unit"
						v-model="record.slug_unit"
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="record.status" dense>
					<v-col cols="12">
						<v-combobox
						:items="type_status_map[record.asset_type_key]" 					
						label="Status Asset"
						v-model="record.status"			
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record"
					:is="record.asset_type_key"/>					
		
			</v-card-text>
		</template>
	</form-edit>
</template>

<script>

// assets type form
import Land from "./edit-part/edit-land";
import Document from "./edit-part/edit-documents";
import Electronic from "./edit-part/edit-electronic";
import Furniture from "./edit-part/edit-furniture";
import Vehicle from "./edit-part/edit-vehicle";

export default {
	name: "infrastructure-assets-edit",

	components : {
		Land,
		Document,
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
                'Document',
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
