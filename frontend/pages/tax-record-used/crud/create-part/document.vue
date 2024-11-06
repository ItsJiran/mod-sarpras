<template>
<!-- INISIASI COMBOS UNITS -->
<div v-if="data.refUnit == undefined"> 
		{{ data.getRefUnit(record,data) }} 
	</div>

	<!-- PILIH UNITS -->
	<v-row v-if="data.refUnit != undefined" dense>
		<v-col cols="12">
			<v-combobox
			:return-object="true"
			:items="data.refUnit.units"
			item-title="name"
			v-model="record.unit"
			@update:model-value="changeUnit(record,data,this)"			
			:label="'Untuk ' + record.type + ' Dari Unit'"		
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH TIPE HUBUNGAN DOKUMEN -->
	<v-row dense>
		<v-col cols="12">
			<v-combobox
			:items="jenisHubungan"
			:return-object="false"
			v-model="record.jenis"
			label="Apakah Dokumen Terhubung Dengan Asset Dari Unit Ini?"		
			@update:model-value="changeDocumentType(record,data,this)"	
			></v-combobox>
		</v-col>
	</v-row>

	<!-- APABILA HUBUNGAN DOKUMEN TERHUBUNG DENGAN ASSET -->
	<div v-if="record.jenis == 'Iya'">

		<!-- PILIH TIPE ASSETS -->
		<v-row v-if="data.refAssetType != undefined" dense>
			<v-col cols="12">
				<v-combobox
				:items="data.refAssetType"
				item-title="name"
				:return-object="false"
				v-model="record.asset.assetable_type_key"
				@update:model-value="changeAssetType(record,data,this)"			
				label="Pilih Jenis Asset"		
				></v-combobox>
			</v-col>
		</v-row>

		<!-- PILIH ASSETS APABILA ASSET ADA -->	
		<v-row v-if="data.refAsset != undefined && data.refAsset.assets != undefined && data.refAsset.assets.length > 0" dense>
			<v-col cols="6">
				<v-combobox
				:items="data.refAsset.assets"
				:return-object="false"
				:readonly="true"
				v-model="record.asset.name"	
				label="Nama Asset"		
				></v-combobox>
			</v-col>
			<v-col cols="6">
				<v-combobox
				:items="data.refAsset.assets_slugs_combos"
				:return-object="false"
				v-model="record.asset.slug"
				@update:model-value="changeAsset(record,data,this)"	
				label="Slug Asset"		
				></v-combobox>
			</v-col>
		</v-row>

		<!-- TAMPILKAN KOSONG APABILA ASSET TIDAK ADA -->	
		<v-row v-if="data.refAsset != undefined && data.refAsset.assets != undefined && data.refAsset.assets.length <= 0" dense>
			<v-btn
				class="mt-2"
				color="teal-darken-4"
				block
				variant="flat"
				:disabled="true"
				>Tidak Ditemukan Asset</v-btn
			>
		</v-row>
	</div>

	<!-- FORM LIST DOCUMENT -->
	<v-row v-if="data.refDocument != undefined && data.refDocument.documents != undefined && data.refDocument.documents.length > 0" dense>			
		<v-col cols="6">
				<v-combobox
				:return-object="false"
				:readonly="true"
				v-model="record.document.name"	
				label="Nama Document"						
				></v-combobox>
			</v-col>
			<v-col cols="6">
				<v-combobox
				:items="data.refDocument.documents_ids_combos"
				:return-object="false"
				v-model="record.document.id"
				@update:model-value="changeDocument(record,data)"	
				label="Id Document"		
				></v-combobox>
			</v-col>
	</v-row>

	<!-- TAMPILKAN KOSONG APABILA ASSET TIDAK ADA -->	
	<v-row v-if="data.refDocument != undefined && data.refDocument.documents != undefined && data.refDocument.documents.length <= 0" dense>					
		<v-btn
			class="mt-2"
			color="teal-darken-4"
			block
			variant="flat"
			:disabled="true"
			>Tidak Ditemukan Dokumen</v-btn
		>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-tax-create-document",
	data(){
		return {
			// tipe hubugan apakah document tersebut terhubung dengan asset dari
			// unit tersebut atau tidak..
			jenisHubungan : [ 'Iya','Tidak' ],	
			jenis : undefined,		
		};
	},
	props: ['record','data'],
	methods:{
		changeUnit:function (record,data,componentData){
			// insiasi object asset untuk pemilihan asset 
			if(record.asset != undefined && record.asset.assetable_type_key != undefined)
				record.asset = { type : record.asset.assetable_type_key };
			else 
				record.asset = {};

			// mengrefresh list asset setiap pergantian unit
			data.refAsset = undefined;

			// mengrefresh list documnet setiap pergantian unit
			data.refDocument = undefined;
		
			// pangggil pilihan tipe asset
			if ( data.refAssetType == undefined )			
				data.getRefAssetType(record,data);

			// apabila jenis hubungan iya
			if( record.jenis == 'Iya' && record.asset != undefined && record.asset.assetable_type_key != undefined )
				data.getRefAsset(record,data);
			
			// apabila jenis hubungan tidak..
			if ( record.jenis == 'Tidak' )
				data.getRefDocument( 
					record, 
					data, 
					record.jenis == 'Iya' 
				);
		},
		changeDocumentType : function (record,data,componentData) {
			// mengrefresh list documnet setiap pergantian tipe document
			data.refDocument = undefined;
			
			// prevent error
			record.document = {};

			console.log(record.jenis,data.refAssetType);
			
			// apabila jenis hubungan tidak.. maka langsung panggil refDocument
			if ( record.jenis == 'Tidak' ) {
				data.getRefDocument( record, data, record.jenis == 'Iya' );
			} else if ( record.jenis == 'Iya' ) {
				if(data.refAssetType == undefined)
					data.getRefAssetType( record, data );
				else 
					data.getRefAsset( record, data );
			}
		},
		changeAssetType:function(record,data){		
			// mengrefresh list documnet setiap pergantian tipe document
			data.refDocument = undefined;

			data.getRefAsset(record,data);

			if(record.asset != undefined && record.asset.assetable_type_key != undefined)
				record.asset = { type : record.asset.assetable_type_key };
			else 
				record.asset = {};
		},
		changeAsset:function(record,data,componentData){
			record.asset = { 
				...record.asset, 
				...data.refAsset.assets_slugs[record.asset.slug] 
			};

			// prevent error
			record.document = {};

			data.getRefDocument( 
				record, 
				data, 
				record.jenis == 'Iya' 
			);
		},
		changeDocument:function(record,data){
			record.document = data.refDocument.documents_ids[record.document.id];
		},
	},
};
</script>
