<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ 
			combos : { 
				morph_type, 
				morph_type_keys, 

				morph_target, 
				morph_target_keys, 
			},
			record }">
			<v-card-text>

				<!-- -------------------- -->
				<!-- +--- INIT EDIT ----+ -->
				<div v-if="!initEditBool"> 
					{{ initEdit(record,this) }} 
				</div>

				<!-- ------------------------ -->
				<!-- +--- DEFAULT PROPS ----+ -->

				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Deskripsi"
							v-model="record.description"
						></v-text-field>
					</v-col>
				</v-row>

				<!-- ------------------------- -->
				<!-- +--- TIPE PERAWATAN ----+ -->

				<div class="text-overline mt-6">Tipe Perawatan</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						label="Tipe Perawatan"
						:disabled="true"
						:return-object="false"
						:items="morph_type_keys" 
						v-model="record.maintenanceable_type_key"
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.maintenanceable_type_key"
				/>

				<!-- ---------------------------------------- -->
				<!-- +--- DEADLINE TIPE PERAWATAN MODEL ----+ -->

				<div class="text-overline mt-6">Tujuan Perawatan</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_target_keys" 
						:return-object="false"
						label="Perawatan Untuk"
						v-model="record.targetable_type_key"		
						@update:model-value="changeTargetType(record,this)"	
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.targetable_type_key"
				/>	

			</v-card-text>
		</template>
	</form-edit>
</template>

<script>

// TARGETABLE TYPE
import Asset from "./edit-part/asset";
import Document from "./edit-part/document";

// MAINTENANCEABLE TYPE
import Log from "./create-part/type_log.vue";
import Periodic from "./create-part/type_periodic.vue";

export default {
	name: "infrastructure-maintenance-edit",
	components : {	
		// TARGETABLE TYPE
		Asset,
		Document,
		// MAINTENANCEABLE TYPE
		Log,
		Periodic,
	},
	data(){	
		return {
			refUnit : undefined,
			refAssetType : undefined,
			refAsset : undefined,
			refDocument : undefined,
			initEditBool : false,
		}
	},
	methods : {
		initEdit : function(record,data) {
			// fetch type data assets
			data.getRefUnit(record,data)
			data.getRefAssetType(record,data);

			// fetch asset
			if ( record.targetable_type_key == 'Asset' || record.targetable_type_key == 'Document' ) {
				data.getRefAsset(record,data);
			}

			// fecth documents
			if ( record.targetable_type_key == 'Document' ) {
				data.getRefDocument(record,data)
			}

			data.initEditBool = true;
		},
		// methods
		changeMaintenaceType : function (record,data) {

		},
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
				(response) => { data.refAssetType = response; }
			);
		},
		getRefAsset : function (record,data) {
			// agar supaya nantinya tidak error
			if ( record.unit == undefined || record.asset == undefined || record.asset.assetable_type_key == undefined )
				return;

			// prevent error call
			data.refAsset = [];

			// ambil asset untuk list 
			this.$http(`infrastructure/api/ref-asset/${record.unit.id}/${record.asset.assetable_type_key}/asset`).then(				
				(response) => { data.refAsset = response }
			);
		},
		getRefDocument : function (record,data) {
			if ( record.jenis == 'Iya' )
				data.getRefDocumentAsset(record,data);

			if ( record.jenis == 'Tidak' )
				data.getRefDocummentUnit(record,data);
		},
		getRefDocummentUnit : function (record,data) {
			if(record.unit == undefined)
				return;

			this.$http(`infrastructure/api/ref-document/combos/unit/${record.unit.id}`).then(				
				(response) => { data.refDocument = response }
			);
		},
		getRefDocumentAsset : function (record,data) {
			console.log('test');
			if(record.unit == undefined || record.asset == undefined)
				return;

			this.$http(`infrastructure/api/ref-document/combos/unit/${record.unit.id}/asset/${record.asset.id}`).then(
				(response) => { data.refDocument = response }
			);
		},
	}
};
</script>
