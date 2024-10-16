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
			:label="'Untuk ' + record.maintenanceable_type + ' Dari Unit'"		
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH TIPE HUBUNGAN DOKUMEN -->
	<v-row dense>
		<v-col cols="12">
			<v-combobox
			:items="jenisHubungan"
			:return-object="false"
			v-model="jenis"	
			label="Apakah Dokumen Terhubung Dengan Asset Dari Unit Ini?"		
			></v-combobox>
		</v-col>
	</v-row>

	<!-- APABILA HUBUNGAN DOKUMEN TERHUBUNG DENGAN ASSET -->
	<div v-if="jenis == 'Iya'">
		<!-- PILIH TIPE ASSETS -->
		<v-row v-if="data.refAssetType != undefined" dense>
			<v-col cols="12">
				<v-combobox
				:items="data.refAssetType"
				item-title="name"
				:return-object="false"
				v-model="record.asset.type"
				@update:model-value="changeAssetType(record,data,componentData)"			
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
				@update:model-value="changeAsset(record,data)"	
				label="Slug Asset"		
				></v-combobox>
			</v-col>
		</v-row>

		<!-- TAMPILKAN KOSONG APABILA ASSET TIDAK ADA -->	
		<v-row v-if="data.refAsset != undefined && data.refAsset.assets != undefined && data.refAsset.assets.length == 0" dense>
			<v-btn
				class="mt-2"
				color="teal-darken-4"
				block
				variant="flat"
				:disabled="true"
				>Tidak Ditemukan</v-btn
			>
		</v-row>
	</div>

	<!-- FORM LIST DOCUMENT -->
	<div v-if="data.refDocument != undefined ">

	</div>


</template>

<script>
export default {
	name: "infrastructure-maintenance-create-document",
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
			if(record.asset != undefined && record.asset.type != undefined)
				record.asset = { type : record.asset.type };
			else 
				record.asset = {};

			// mengrefresh list asset setiap pergantian unit
			data.refAsset = undefined;
			
			// pangggil pilihan tipe asset
			if ( data.refAssetType == undefined )			
				data.getRefAssetType(record,data);

			// apabila jenis hubungan iya
			if( componentData.jenisHubungan == 'Iya' && record.asset != undefined && record.asset.type != undefined )
				data.getRefAsset(record,data);
			
			// apabila jenis hubungan tidak..
			if ( componentData.jenisHubungan == 'Tidak' )
				data.getRefDocument( 
					record, 
					data, 
					componentData.jenisHubungan == 'Iya' 
				);
		},
		changeDocumentType : function (record,data,componentData) {		
			// prevent error
			record.document = {};
			
			// apabila jenis hubungan tidak.. maka langsung panggil refDocument
			if ( componentData.jenisHubungan == 'Tidak' )
				data.getRefDocument( 
					record, 
					data, 
					componentData.jenisHubungan == 'Iya' 
				);
		},
		changeAssetType:function(record,data){			
			data.getRefAsset(record,data);
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
				componentData.jenisHubungan == 'Iya' 
			);
		},
	},
};
</script>
