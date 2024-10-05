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
						@update:model-value="getItemType(record, units, this)"
						></v-combobox>
					</v-col>
				</v-row>

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-tax-create",
	data(){
		return {
			formType: [
				'LandCertificate',
			],

			unit : {},
			unit_slug : undefined,
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

		getItemType : function (record, units, data) {
			data.unit = units[data.unit_slug];
		},

		getItemList : function (record, data) {

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
