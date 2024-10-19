<template>

	<!-- INISIASI COMBOS UNITS -->
	<div v-if="data.refUnit == undefined"> 
		{{ data.getRefUnit(record,data) }} 
		{{ initEdit(record,data) }} 
	</div>

	<!-- PILIH UNITS -->
	<v-row v-if="data.refUnit != undefined" dense>
		<v-col cols="12">
			<v-combobox
			:return-object="true"
			:items="data.refUnit.units"
			item-title="name"
			v-model="record.unit"
			@update:model-value="changeUnit(record,data)"	
			:label="'Untuk ' + record.targetable_type_key + ' Dari Unit'"		
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH TIPE ASSETS -->
	<v-row v-if="data.refAssetType != undefined" dense>
		<v-col cols="12">
			<v-combobox
			:items="data.refAssetType"
			item-title="name"
			:return-object="false"
			v-model="record.asset.assetable_type_key"
			@update:model-value="changeAssetType(record,data)"
			label="Pilih Jenis Asset"
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH ASSETS -->
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

</template>

<script>
export default {
	name: "infrastructure-maintenance-edit-asset",
	props: ['record','data'],
	methods:{		
		changeUnit:function (record,data){
			// insiasi object asset untuk pemilihan asset 
			if(record.asset != undefined && record.asset.assetable_type_key != undefined)
				record.asset = { type : record.asset.assetable_type_key };
			else 
				record.asset = {};

			// mengrefresh list asset setiap pergantian unit
			data.refAsset = undefined;
			
			// pangggil pilihan tipe asset
			if ( data.refAssetType == undefined )			
				data.getRefAssetType(record,data);

			// apabila ternyata tipe asset sudah ada
			if( record.asset != undefined && record.asset.assetable_type_key != undefined )
				data.getRefAsset(record,data);
		},
		changeAssetType:function(record,data){			
			data.getRefAsset(record,data);
		},
		changeAsset:function(record,data){
			record.asset = { 
				...record.asset, 
				...data.refAsset.assets_slugs[record.asset.slug] 
			};
		}
	},
};
</script>
