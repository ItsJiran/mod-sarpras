<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos: { type_key, units, units_slug, type_status_map, status },			
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
						<v-text-field
							label="Description"
							v-model="record.description"
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
				</v-row>

				<div class="text-overline mt-6">Form Document</div>
				<v-divider :thickness="3" class="mt-3 mb-10" />

				<v-row dense>					
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Document"
						v-model="record.documentable_type_key"
						:return-object="false"
						@update:model-value="selectType(record, this)"
						></v-combobox>
					</v-col>
				</v-row>

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
import LandCertificate from "./create-part/create-land-certificate";

export default {
	name: "infrastructure-unit-asset-document-create",
	components : {
		LandCertificate,
	},
	data(){
		return {
			currentFormType:"",
			formType: [
				'LandCertificate',
			],
		}
	},
	methods : {		
		selectType : function (record, data) {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
