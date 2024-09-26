<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos: { type_key, units, units_slug },
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
						v-model="record.assets_type_key"
						:return-object="false"
						@update:model-value="currentFormType = record.assets_type_key"
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
						@update:model-value="unit = units[record.unit_slug]"
						></v-combobox>
					</v-col>			
				</v-row>

				<component :record="record" :is="currentFormType"></component>
				
			</v-card-text>
		</template>
	</form-create>
</template>

<script>

// assets type form
import Land from "./create-part/create-land";
import Document from "./create-part/create-documents";
import Electronic from "./create-part/create-electronic";
import Furniture from "./create-part/create-furniture";
import Vehicle from "./create-part/create-vehicle";

export default {
	name: "infrastructure-assets-create",

	components : {
		Land,
		Document,
		Electronic,
		Furniture,
		Vehicle,
	},

	data(){
		return {
			currentFormType:'Land',
			formType: [
				'Vehicle',
                'Furniture',
                'Electronic',
                'Document',
                'Land', 
			],
			unit: {

			}
		}
	},

	setup(props){
		console.log(props.components);
	}
};
</script>
