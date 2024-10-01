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
							v-model="record.slug_unit"
							@update:model-value="selectUnit(record, units, this)"
							></v-combobox>
						</v-col>
					</v-row>




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
			],
			unit: {}
		}
	},
	methods : {
		selectUnit : (record, units, data) => {			
			data.unit = units[record.slug_unit];
		},
		selectType : (record, data) => {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
