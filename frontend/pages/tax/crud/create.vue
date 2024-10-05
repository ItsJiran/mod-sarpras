<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos: { type, type_key, units, units_slug },			
			record,
			store
			}">
			<v-card-text>

				<div class="text-overline mt-6">Form Pajak Tujuan</div>
				<v-divider :thickness="3" class="mt-3 mb-10" />

				<v-row dense>					
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Pajak Tujuan"
						v-model="record.taxable_type_key"
						@update:model-value="getItemList(record,this)"
						:return-object="false"
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
						v-model="unit_slug"
						@update:model-value="getItemUnit(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="unit_slug != undefined" dense>
					<v-col cols="12">
						<v-combobox
						:items="asset_types" 
						label="Pilih Tipe Asset"
						v-model="asset_type"
						@update:model-value="getAssetList(record, this)"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="unit_slug != undefined && asset_type != undefined" dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Asset"
							v-model="item.asset.name"
							:readonly="true"
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="assets_slugs_combos" 
						label="Pilih Asset Slug"
						v-model="item.asset.slug"
						@update:model-value="getAsset(record, this)"
						></v-combobox>
					</v-col>
				</v-row>


				<!-- <v-row v-if="unit_slug != undefined && record.taxable_type_key == 'Asset' && items != undefined" dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Asset"
							v-model="item.name"
							:readonly="true"
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						:items="items_slugs" 
						label="Pilih Asset Slug"
						v-model="item.slug"
						@update:model-value="getAsset(record, this)"
						></v-combobox>
					</v-col>
				</v-row> -->

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-tax-create",
	data(){
		return {
			item : {
				asset : {},
				document : {},
			},

			unit : {},
			unit_slug : undefined,

			assets : undefined,
			assets_slugs : undefined,
			assets_slugs_combos : undefined,
			
			asset_type : undefined,
			asset_types : undefined,
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

		getItemUnit : function (record, units, data) {
			data.unit = units[data.unit_slug];

			// reset
			data.item = {
				asset : {},
				document : {},
			};

			data.getItemList(record,data);

		},

		getItemList : function (record, data) {
			const isUnitlugExist = data.unit_slug != undefined;
			const isTaxKeyExist = data.taxable_type_key != undefined;

			// prevent error
			if( !isUnitlugExist && !isTaxKeyExist ) return;

			// call items list based on the type of the record taxable
			data.getAssetType(record,data);
		},

		getAssetType : function ( record, data ) {			
			if ( data.asset_types ) 
				return data.getAssetList( record, data );
			
			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => data.asset_types = response				
			);
		},

		getAssetList : function (record, data) {
			if ( data.asset_type == undefined || data.unit.id == undefined  )
				return;

			this.$http(`infrastructure/api/ref-asset/${data.unit.id}/${data.asset_type}/asset`).then(
				(response) => {
					data.assets = response.assets;
					data.assets_slugs = response.assets_slugs;
					data.assets_slugs_combos = response.assets_slugs_combos;
				}
			)
		},

		getAsset : function (record, data) {	
			data.item.asset = data.assets_slugs[ data.item.asset.slug ];
		},

		getDocument : function (record,data) {

		}
		
		// getAssetType : function ( record, units, data ) {			
		// 	data.unit = units[data.asset.slug_unit];

		// 	record.asset = {};

		// 	if ( data.assets_types ) {
		// 		data.getAssetList( record, data );
		// 		return;
		// 	}  
			
		// 	data.asset_list = undefined;
		// 	data.assets_slugs = undefined;
		// 	data.assets_slugs_combos = undefined;

		// 	this.$http(`infrastructure/api/ref-asset/type`).then(
		// 		(response) => {
		// 			data.assets_types = response;
		// 		}
		// 	);
		// },

		// getAssetList : function ( record, data ) {
		// 	record.asset = {};

		// 	data.assets = undefined;
		// 	data.assets_slugs = undefined;
		// 	data.assets_slugs_combos = undefined;

		// 	this.$http(`infrastructure/api/ref-asset/${data.unit.id}/${data.asset.asset_type_key}/asset`).then(
		// 		(response) => {
		// 			data.assets_slugs_combos = response.assets_slugs_combos;
		// 			data.assets_slugs = response.assets_slugs;
		// 			data.assets = response.assets;
		// 		}
		// 	)
		// },

		// getAsset : function (record, data) {
		// 	data.asset = {
		// 		...data.asset,
		// 		...data.assets_slugs[data.asset.slug]
		// 	};

		// 	record.asset = data.asset;
		// },
	}

};
</script>
