<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { 
				morph_type, 
				morph_type_keys, 

				types, 
				types_documents
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
				<!-- +--- TIPE PERAWATAN ----+ -->

				<div class="text-overline mt-6">Tipe Perawatan</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="types" 
						label="Tipe Perawatan"
						v-model="record.type"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="record.type != undefined && record.type == 'berkala'" dense>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Hari"
						v-model="record.period_number_day"
						:min="0"
						></v-number-input>
					</v-col>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Bulan"
						v-model="record.period_number_month"
						:min="0"
						></v-number-input>
					</v-col>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Tahun"
						v-model="record.period_number_year"
						:min="0"
						></v-number-input>
					</v-col>
				</v-row>

				<!-- -------------------------------------- -->
				<!-- +--- DEADLINE TANGGAL PEMBAYARAN ----+ -->

				<div class="text-overline mt-6">Deadline Tanggal Pembayaran</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-date-input
							label="Deadine Tanggal Pembayaran"
							v-model="record.duedate"
						></v-date-input>
					</v-col>
				</v-row>

				<!-- ---------------------------------------- -->
				<!-- +--- DEADLINE TIPE PERAWATAN MODEL ----+ -->

				<div class="text-overline mt-6">Tujuan Perawatan</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_type_keys" 
						:return-object="false"
						label="Perawatan Untuk"
						v-model="record.maintenanceable_type"			
						></v-combobox>
					</v-col>
				</v-row>

				<component :record="record" :data="this" :is="record.maintenanceable_type"/>	

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
import Asset from "./create-part/asset";
import Document from "./create-part/document";

export default {
	name: "infrastructure-maintenance-create",
	components : {	
		Asset,
		Document,
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
			// prevent error call
			data.refAsset = [];

			// ambil asset untuk list 
			this.$http(`infrastructure/api/ref-asset/${record.unit.id}/${record.asset.type}/asset`).then(				
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
		


		// addTargetAsset : function (data) {
		// 	// prevent error
		// 	for( let target of data.target_assets_needed ) {
		// 		if(target.id == data.target_asset.id) return;
		// 	}

		// 	data.targets_assets_needed.push( data.target_asset );
		// },
		// addTargetDocument : function (data) {
		// 	data.targets_documents_needed.push( data.target_document );
		// },
		// addtarget : function (data) {
		// 	if ( data.target_type == 'Asset' ) {
		// 		data.addTargetAsset(data);
		// 	} else if ( data.target_type == 'Document' ) {
		// 		data.addTargetDocument(data);
		// 	}
		// },

		// getAssetType : function (data) {
		// 	if ( data.assets_types ) 
		// 		return data.getAssetList( record, data );	

		// 	this.$http(`infrastructure/api/ref-asset/type`).then(
		// 		(response) => {
		// 			data.target_asset_types = response;
		// 		}
		// 	);
		// },
		// getAssetList : function (data) {
		// 	// reset every new asset list fetched
		// 	data.target_asset = {};
		// 	data.target_documents = [];

		// 	// reset every new asset list fetched
		// 	data.target_asset_slugs_combos = undefined;
		// 	data.target_asset_slugs = undefined;
		// 	data.target_assets = undefined;

		// 	// fetch list asset
		// 	this.$http(`infrastructure/api/ref-asset/${data.target_unit.id}/${data.target_type_key}/asset`).then(
		// 		(response) => {
		// 			data.target_asset_slugs_combos = response.assets_slugs_combos;
		// 			data.target_asset_slugs = response.assets_slugs;
		// 			data.target_assets = response.assets;
		// 		}
		// 	)
		// },
		
		// getDocumentsListByUnit : function (data) {
		// 	if(data.target_unit.id == undefined) return;
		// 	data.target_documents = [];

		// 	this.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}`).then(
		// 		(response) => {
		// 			data.target_documents_ids_combos = response.documents_ids_combos;
		// 			data.target_documents_ids = response.documents_ids;
		// 			data.target_documents = response.documents;
		// 		}
		// 	)
		// },	
		// getDocumentsListByAsset : function (data) {
		// 	if(data.target_asset.id == undefined) return;
		// 	data.target_documents = [];

		// 	this.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}/asset/${data.target_asset.id}`).then(
		// 		(response) => {
		// 			data.target_documents_ids_combos = response.documents_ids_combos;
		// 			data.target_documents_ids = response.documents_ids;
		// 			data.target_documents = response.documents;
		// 		}
		// 	)
		// },	

		// targetChangeDocumentType: function (record, data) {
		// 	data.target_document = {};
		// 	record.target = undefined;
		// 	record.target_type = undefined;

		// 	if( data.target_type_document == 'Asset' ){
		// 		data.getDocumentsListByAsset(data);
		// 	} else if( data.target_type_document == 'Unit' ) {
		// 		data.getDocumentsListByUnit(data);
		// 	}
		// },

		// targetChangeAsset : function (record,data) {
		// 	data.target_asset = data.target_asset_slugs[ data.target_asset.slug ];

		// 	// record target
		// 	if(data.target_type == 'Asset'){
		// 		record.target = data.target_asset;
		// 		record.target_type = data.target_type;
		// 	}

		// 	if ( data.target_type_document == 'Asset' ) {
		// 		data.getDocumentsListByAsset(data);
		// 	}
		// },
		// targetChangeDocument : function (record,data) {
		// 	data.target_document = data.target_documents_ids[data.target_document.id];

		// 	// record target
		// 	record.target = data.target_document;
		// 	record.target_type = data.target_type;
		// },
		// targetChangeUnit : function (data, units) {
		// 	data.target_unit = units[data.target_unit.slug];
		// 	data.target_asset = {};
		// 	data.getAssetType(data);
		// },
		// targetChangeType : function (data) {
		// 	data.getAssetList(data);
		// },		
	}
};
</script>
