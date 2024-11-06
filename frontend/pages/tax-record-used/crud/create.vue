<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { types },
			record, }">
			<v-card-text>
				
				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="types" 
						label="Tipe Yang Digunakan"
						v-model="record.type"
						:return-object="false"
						@update:model-value="changeTargetType(record,this)"
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.type"
				/>


			</v-card-text>
		</template>
	</form-create>
</template>

<script>

// TARGETABLE TYPE
import asset from "./create-part/asset";
import document from "./create-part/document";

export default {
	name: "infrastructure-tax-record-used-create",
	components : {	
		// TARGETABLE TYPE
		asset,
		document,
	},	
	data(){	
		return {
			refUnit : undefined,
			refAssetType : undefined,
			refAsset : undefined,
			refDocument : undefined,
		}
	},
	methods : {
		// methods
		changeTargetType : function (record,data) {
			// reset data ref prevent unwanted behaviour
			data.refAsset = undefined;
			data.refDocument = undefined;

			// reset data from previous
			if( record.asset != undefined ) {
				record.asset = { 
					assetable_type_key : record.asset.assetable_type_key 
				};
				
				data.getRefAsset(record,data);
			} else {
				record.asset = {};
			}

			record.document = {};
		},
		// get refrences
		getRefUnit : function (record,data) {
			if(data.refAssetType != undefined) return;

			// prevent loop call
			data.refUnit = {};

			this.$http(`infrastructure/api/ref-unit/combos`).then(
				(response) => { data.refUnit = response; }
			);
		},
		getRefAssetType : function (record,data) {
			if(data.refAssetType != undefined) return;
			
			// prevent loop call
			data.refAssetType = [];

			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => { 
					data.refAssetType = response; 
				}
			);
		},
		getRefAsset : function (record,data) {
			// agar supaya nantinya tidak error
			if ( record.unit == undefined || record.asset.assetable_type_key == undefined )
				return;

			// prevent error call
			data.refAsset = [];

			// ambil asset untuk list 
			this.$http(`infrastructure/api/ref-asset/${record.unit.id}/${record.asset.assetable_type_key}/asset`).then(				
				(response) => { data.refAsset = response }
			);
		},
		getRefDocument : function (record,data,isConnectedToAsset) {
			if ( isConnectedToAsset == undefined ) 
				return;

			if ( isConnectedToAsset )
				data.getRefDocumentAsset(record,data);

			if ( !isConnectedToAsset )
				data.getRefDocummentUnit(record,data);
		},
		getRefDocummentUnit : function (record,data) {
			this.$http(`infrastructure/api/ref-document/combos/unit/${record.unit.id}`).then(				
				(response) => { data.refDocument = response }
			);
		},
		getRefDocumentAsset : function (record,data) {
			this.$http(`infrastructure/api/ref-document/combos/unit/${record.unit.id}/asset/${record.asset.id}`).then(
				(response) => { data.refDocument = response }
			);
		},
	}
};
</script>
