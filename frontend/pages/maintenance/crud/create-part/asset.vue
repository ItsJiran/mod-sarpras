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
			@update:model-value="changeUnit(record,data)"			
			:label="'Untuk ' + record.maintenanceable_type + ' Dari Unit'"		
			></v-combobox>
		</v-col>
	</v-row>

	<!-- PILIH TIPE ASSETS -->
	<v-row v-if="data.refAssetType != undefined" dense>
		<v-col cols="12">
			<v-combobox
			:items="data.refAssetType"
			v-model="record.asset.type"
			@update:model-value="changeAssetType(record,data)"			
			label="Pilih Asset Dari Unit Ini"		
			></v-combobox>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-maintenance-create-asset",
	props: ['record','data'],
	methods:{
		changeUnit:function (record,data){
			// insiasi object asset untuk pemilihan asset 
			record.asset = {};
			
			// pangggil pilihan tipe asset
			if(data.refAssetType == undefined)
				data.getRefAssetType(record,data);
		},
		changeAssetType:function(record,data){

		},
		changeAsset:function(record,data){

		}
	},
};
</script>
