<template>

	<!-- PILIH UNITS -->
	<v-row dense>
		<v-col cols="12">
			<v-combobox
			v-model="record.unit.name"
			:label="'Untuk ' + record.targetable_type_key + ' Dari Unit'"		
			:readonly="true"
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH TIPE ASSETS -->
	<v-row dense>
		<v-col cols="12">
			<v-combobox
			item-title="name"
			:return-object="false"
			v-model="record.asset.assetable_type_key"
			label="Pilih Jenis Asset"
			:readonly="true"
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH ASSETS -->
	<v-row dense>
		<v-col cols="6">
			<v-combobox
			:return-object="false"
			:readonly="true"
			v-model="record.asset.name"	
			label="Nama Asset"
			></v-combobox>
		</v-col>
		<v-col cols="6">
			<v-combobox
			:return-object="false"
			v-model="record.asset.slug"
			label="Slug Asset"		
			:readonly="true"
			></v-combobox>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-maintenance-show-asset",
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
