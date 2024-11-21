<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { 
				morph_record, 
				morph_record_keys, 

				morph_target, 
				morph_target_keys, 
			},
			record }">

			<v-card-text>
				
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
				<!-- +--- TIPE Record ----+ -->

				<div class="text-overline mt-6">Tipe Record</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_record_keys" 
						label="Tipe Record"
						v-model="record.recordable_type_key"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.recordable_type_key"
				/>

				<!-- ---------------------------------------- -->
				<!-- +--- DEADLINE TIPE Record MODEL ----+ -->

				<div v-if=" checkRoute('infrastructure-tax-create') || 
						    checkRoute('infrastructure-maintenance-create') || 
							checkRoute('infrastructure-deadline-create')">

					<div class="text-overline mt-6">Tujuan Record</div>
					<v-divider :thickness="3" class="mt-3 mb-6" />

					<v-row dense>
						<v-col cols="12">
							<v-combobox
							:items="morph_target_keys" 
							:return-object="false"
							label="Record Untuk"
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

				</div>

			</v-card-text>

		</template>
	</form-create>
</template>

<script>

// TARGETABLE TYPE
import Asset from "./create-part/asset";
import Document from "./create-part/document";

// taxable TYPE
import Log from "./create-part/type_log.vue";
import Periodic from "./create-part/type_periodic.vue";

export default {
	name: "infrastructure-record-create",
	components : {	
		// TARGETABLE TYPE
		Asset,
		Document,
		// taxable TYPE
		Log,
		Periodic,
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
		checkRoute : function (name = "") {
			// route_name
			let route_name = this.$router.currentRoute._value.name;
			let methods = ['show','delete','update','edit','create'];

			for ( let method of methods ) 
				route_name = route_name.replaceAll('-' + method,'');
			
			return route_name == name;
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
