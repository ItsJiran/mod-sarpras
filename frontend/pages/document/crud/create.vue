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

				<component :record="record" :is="currentFormType"/>	

				<div class="text-overline mt-6">Form Asset Tujuan (optional)</div>
				<v-divider :thickness="3" class="mt-3 mb-10" />

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

				<v-row v-if="record.slug_unit != undefined" dense>
					<v-col cols="12">
						<v-combobox
						:items="assets_types" 
						label="Pilih Tipe Asset"
						v-model="record.asset_type"
						@update:model-value="getAssetList(record, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row v-if="record.asset_type != undefined && assets_slugs_combos != undefined && assets_slugs_combos.length > 0" dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Asset"
							v-model="asset.name"
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="assets_slugs_combos" 
						label="Pilih Asset Slug"
						v-model="record.asset_slug"
						@update:model-value="getAsset(record, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="record.asset_type != undefined && assets_slugs_combos != undefined && assets_slugs_combos.length <= 0" dense>					
					Tidak Ditemukan
				</v-row>

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
			asset : {},

			assets:undefined,
			assets_slugs:undefined,
			assets_slugs_combos:undefined,
			assets_types:undefined,
		}
	},
	methods : {		
		getAssetType : function ( record, units, data ) {			
			data.unit = units[record.slug_unit];

			if ( data.assets_types ) {
				data.getAssetList( record, data );
				return;
			}  
			
			data.asset_list = undefined;
			data.assets_slugs = undefined;
			data.assets_slugs_combos = undefined;

			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => {
					data.assets_types = response;
				}
			);
		},

		getAssetList : function ( record, data ) {
			record.asset = {};
			record.asset_id = undefined;
			record.asset_slug = undefined;

			data.asset = {};
			data.assets = undefined;
			data.assets_slugs = undefined;
			data.assets_slugs_combos = undefined;

			this.$http(`infrastructure/api/ref-asset/${data.unit.id}/${record.asset_type}/asset`).then(
				(response) => {
					data.assets_slugs_combos = response.assets_slugs_combos;
					data.assets_slugs = response.assets_slugs;
					data.assets = response.assets;
				}
			)
		},

		getAsset : function (record, data) {
			data.asset = data.assets_slugs[record.asset_slug];
			record.asset_id = data.asset.id;
		},

		selectType : function (record, data) {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
