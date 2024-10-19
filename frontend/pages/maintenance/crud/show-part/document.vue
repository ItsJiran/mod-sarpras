<template>

	<div v-if="jenis == undefined">
		{{ initShowDocument(record,data) }}
	</div>
	
	<!-- PILIH UNITS -->
	<v-row dense>
		<v-col cols="12">
			<v-combobox
			:return-object="true"
			item-title="name"
			v-model="record.unit"			
			:label="'Untuk ' + record.targetable_type_key + ' Dari Unit'"		
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
			></v-combobox>
		</v-col>
	</v-row>

	<!-- APABILA HUBUNGAN DOKUMEN TERHUBUNG DENGAN ASSET -->
	<div v-if="record.jenis == 'Iya'">
		<!-- PILIH TIPE ASSETS -->
		<v-row dense>
			<v-col cols="12">
				<v-combobox
				item-title="name"
				:return-object="false"
				v-model="record.asset.assetable_type_key"				
				label="Pilih Jenis Asset"		
				></v-combobox>
			</v-col>
		</v-row>

		<!-- PILIH ASSETS APABILA ASSET ADA -->	
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
				></v-combobox>
			</v-col>
		</v-row>

	</div>

	<!-- FORM LIST DOCUMENT -->
	<v-row dense>			
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
				:return-object="false"
				:readonly="true"
				v-model="record.document.id"				
				label="Id Document"		
				></v-combobox>
			</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-maintenance-show-document",
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
		initShowDocument : function (record,data) {
			if ( record.asset != undefined ) data.jenis = 'Iya';
			else 							 data.jenis = 'Tidak';			
		},
	},
};
</script>
