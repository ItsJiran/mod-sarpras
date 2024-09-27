<template>
	<form-show
		with-helpdesk
	>
		<template v-slot:default="{ record }">
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
						v-model="record.assets_type_key"
						:return-object="false"
						@update:model-value="selectAssetsType(record, units_status_map, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row dense>
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
						v-model="record.unit_slug"
							:readonly="true"					
						@update:model-value="selectUnit(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if=" unit.name != undefined && currentFormType != '' " dense>
					<v-col cols="12">
						<v-combobox
						:items="units_status_map[currentFormType]" 
						:return-object="false"
							:readonly="true"					
						label="Status Asset"
						v-model="record.status"			
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					v-if=" unit.name != undefined && currentFormType != '' "
					:record="record"
					:is="currentFormType"/>					
		
			</v-card-text>
		</template>

		<template v-slot:helpdesk>


		</template>
	</form-show>
</template>

<script>

// assets type form
import Land from "./show-part/show-land";
import Document from "./show-part/show-documents";
import Electronic from "./show-part/show-electronic";
import Furniture from "./show-part/show-furniture";
import Vehicle from "./show-part/show-vehicle";

export default {
	name: "infrastructure-assets-show",

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
			data.unit = units[record.unit_slug];
		},
		selectAssetsType : (record, status_map, data) => {
			data.currentFormType = record.assets_type_key;
			record.status = status_map[record.assets_type_key][0];
		}
	},
};
</script>
