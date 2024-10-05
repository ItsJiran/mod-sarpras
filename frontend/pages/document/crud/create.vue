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

				<div class="text-overline mt-6">Form Unit Tujuan</div>
				<v-divider :thickness="3" class="mt-3 mb-5" />

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
						v-model="asset.slug_unit"
						@update:model-value="getAssetType(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<div v-if=" !checkRoute('infrastructure-unit-asset-document') && !checkRoute('infrastructure-asset-document') && asset.slug_unit != undefined">
					<div class="text-overline mt-6">Form Asset Tujuan (optional)</div>
					<v-divider :thickness="3" class="mt-3 mb-5" />

					<v-row v-if="asset.slug_unit != undefined" dense>
						<v-col cols="12">
							<v-combobox
							:items="assets_types" 
							label="Pilih Tipe Asset"
							v-model="asset.asset_type_key"
							@update:model-value="getAssetList(record, this)"
							></v-combobox>
						</v-col>	
					</v-row>

					<v-row v-if="asset.asset_type_key != undefined && assets_slugs_combos != undefined && assets_slugs_combos.length > 0" dense>
						<v-col cols="6">
							<v-text-field
								label="Nama Asset"
								v-model="asset.name"
								:readonly="true"
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="assets_slugs_combos" 
							label="Pilih Asset Slug"
							v-model="asset.slug"
							@update:model-value="getAsset(record, this)"
							></v-combobox>
						</v-col>
					</v-row>

					<v-row v-if="asset.asset_type_key != undefined && assets_slugs_combos != undefined && assets_slugs_combos.length <= 0" dense>					
						Tidak Ditemukan
					</v-row>
				</div>

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
		checkRoute : function (name = "") {
			// route_name
			let route_name = this.$router.currentRoute._value.name;
			let methods = ['show','delete','update','edit','create'];

			for ( let method of methods ) 
				route_name = route_name.replaceAll('-' + method,'');
			
			return route_name == name;
		},

		getAssetType : function ( record, units, data ) {			
			data.unit = units[data.asset.slug_unit];

			record.asset = {};

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

			data.assets = undefined;
			data.assets_slugs = undefined;
			data.assets_slugs_combos = undefined;

			if(data.unit.id == undefined || data.asset.asset_type_key == undefined) return;

			this.$http(`infrastructure/api/ref-asset/${data.unit.id}/${data.asset.asset_type_key}/asset`).then(
				(response) => {
					data.assets_slugs_combos = response.assets_slugs_combos;
					data.assets_slugs = response.assets_slugs;
					data.assets = response.assets;
				}
			)
		},

		getAsset : function (record, data) {
			data.asset = {
				...data.asset,
				...data.assets_slugs[data.asset.slug]
			};

			record.asset = data.asset;
		},

		selectType : function (record, data) {
			data.currentFormType = record.documentable_type_key;
		}
	},
};
</script>
