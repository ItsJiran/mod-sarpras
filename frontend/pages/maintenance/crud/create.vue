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
						@update:model-value="changeMaintenanceType(record,this)"	
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
		// methods
		changeMaintenanceType : function (record,data) {
			// reset data ref prevent unwanted behaviour
			data.refAsset = undefined,
			data.refAssetType = undefined,
			data.refDocument = undefined,
			// reset data from preivous
			record.asset = undefined;
			record.document = undefined;
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
			// prevent error call
			data.refAsset = [];

			// ambil asset untuk list 
			this.$http(`infrastructure/api/ref-asset/${record.unit.id}/${record.asset.type}/asset`).then(				
				(response) => { data.refAsset = response }
			);
		},
		getRefDocument : function (record,data,isConnectedToAsset) {
			console.log(isConnectedToAsset);

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
