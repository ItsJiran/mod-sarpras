<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
						></v-text-field>
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

