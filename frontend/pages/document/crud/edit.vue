<template>
	<form-edit with-helpdesk>
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
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<div class="text-overline mt-6">Terhubung Ke Asset</div>
				<v-divider :thickness="3" class="mt-3 mb-10" />


				<v-row v-if="record.asset != undefined" dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Unit"
							v-model="units[record.asset.slug_unit].name"
							:readonly="true"					
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="units_slug" 
						label="Pilih Unit"
						v-model="record.asset.slug_unit"
						@update:model-value="getAssetType(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="record.asset != undefined && record.asset.slug_unit != undefined" dense>
					<v-col cols="12">
						<v-combobox
						:items="assets_types" 
						label="Pilih Tipe Asset"
						v-model="record.asset.asset_type_key"
						@update:model-value="getAssetList(record, units, this)"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row v-if="record.asset != undefined && record.asset.asset_type_key != undefined" dense>
					<v-col cols="6">
					<v-text-field
						label="Nama Asset"
						v-model="record.asset.name"
						:readonly="true"
					></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="assets_slugs_combos" 
						label="Pilih Asset Slug"
						v-model="record.asset.slug"
						@update:model-value="getAsset(record, this)"
						></v-combobox>
					</v-col>
				</v-row>

			</v-card-text>
		</template>
	</form-edit>
</template>


<script>
import LandCertificate from "./edit-part/edit-land-certificate";

export default {
	name: "infrastructure-document-edit",
	components : {
		LandCertificate,
	},
	data(){
		return {
			currentFormType:"",
			formType: [
				'LandCertificate',
			],
			
			assets:undefined,
			assets_slugs:undefined,
			assets_slugs_combos:undefined,
			assets_types:undefined,
		}
	},
	methods : {
		getAssetType : function ( record, units, data ) {			
			record.asset = {
				'slug_unit' : record.asset.slug_unit,
			};

			if ( data.assets_types != undefined ) {
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

		getAssetList : function ( record, units, data ) {
			record.asset = {
				'asset_type_key' : record.asset.asset_type_key,
				'slug_unit' : record.asset.slug_unit,
			};			

			data.assets = undefined;
			data.assets_slugs = undefined;
			data.assets_slugs_combos = undefined;

			this.$http(`infrastructure/api/ref-asset/${units[record.asset.slug_unit].id}/${record.asset.asset_type_key}/asset`).then(
				(response) => {
					data.assets_slugs_combos = response.assets_slugs_combos;
					data.assets_slugs = response.assets_slugs;
					data.assets = response.assets;
				}
			)
		},

		getAsset : function (record, data) {
			record.asset = {
				...record.asset,
				...data.assets_slugs[record.asset.slug]
			};
		},


		selectType : function (record, data) {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>

