<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { status, type_key },
			record
			}">
			<v-card-text>
				<v-row dense>
					
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
						></v-text-field>
					</v-col>

					<v-col cols="12">
						<v-combobox
						:items="status" 
						label="Status"
						v-model="record.status"
						:return-object="false"
						></v-combobox>
					</v-col>

					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Assets"
						v-model="record.documentable_type_key"
						:return-object="false"
						@update:model-value="selectType(record, this)"
						></v-combobox>
					</v-col>

				</v-row>
			</v-card-text>

			<component :record="record" :is="currentFormType"/>	

		</template>
	</form-create>
</template>

<script>
import LandCertificate from "./create-part/create-land-certificate";

export default {
	name: "infrastructure-document-create",
	components : {
		LandCertificate,
	},
	data(){
		return {
			currentFormType:"",
			formType: [
				'LandCertificate',
			]
		}
	},
	methods : {
		// selectUnit : (record, units, data) => {			
		// 	data.unit = units[record.slug_unit];
		// },
		// selectAssetsType : (record, status_map, data) => {
		// 	data.currentFormType = record.asset_type_key;
		// 	record.status = status_map[record.asset_type_key][0];
		// }
		selectType : (record, data) => {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
