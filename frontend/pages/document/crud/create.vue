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
						label="Tipe Document"
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
							@update:model-value="getAssetType(record, units, this)"
							></v-combobox>
						</v-col>
					</v-row>
				</v-row>

				<v-row v-if="record.slug_unit != undefined" dense>
					<v-col cols="12">
						<v-combobox
						:items="asset_types" 
						label="Pilih Tipe Asset"
						v-model="asset_type"
						@update:model-value="getAssetList(record, units, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<component :record="record" :is="currentFormType"/>	

			</v-card-text>
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

			unit : {},

			asset_type:undefined,
			asset_types:undefined,

			asset_id:undefined,
			asset_list:undefined,
		}
	},
	methods : {		
		getAssetType : function ( record, units, data ) {			
			data.unit = units[record.slug_unit];

			if ( data.asset_types ) {
				return;
			}  
			
			data.asset_list = undefined

			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => {
					data.asset_types = response;
				}
			);
		},

		getAssetList : function (record, units, data) {


			this.$http(`infrastructure/api/ref-asset/${data.unit.id}/${data.asset_type}/asset`).then(
				(response) => {
					data.asset_list = response;
				}
			)

		},

		selectType : function (record, data) {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
