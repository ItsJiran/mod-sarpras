<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { 
				morph_type, 
				morph_type_keys, 
				types, 
				types_documents, 
				units, 
				units_slug 
			},
			record }">

			<v-card-text>
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

				<div class="text-overline mt-6">Form Pencarian Asset atau Dokumen Yang Terhubung</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<div class="px-2 py-2">

					<v-row dense>
						<v-col cols="6">
							<v-text-field
								label="Nama Unit"
								v-model="target_unit.name"
								:readonly="true"
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="units_slug" 
							label="Slug Unit"
							v-model="target_unit.slug"
							:return-object="false"
							@update:model-value=" targetChangeUnit(this,units) "
							></v-combobox>
						</v-col>
					</v-row>

					<v-row dense>
						<v-col cols="12">
							<v-combobox
							:items="morph_type_keys" 
							label="Tipe Tujuan"
							v-model="target_type"
							:return-object="false"
							></v-combobox>
						</v-col>
					</v-row>
					
					<!-- FORM UNTUK PENCARIAN DOKUMEN PADA ASSET -->
					<div v-if="target_type == 'Document'">

						<!-- DOCUMENT -->
						<v-row dense>
							<v-col cols="12">
								<v-combobox
								:items="types_documents" 
								label="Tipe Dokumen Terhubung Ke Mana"
								v-model="target_type_document"
								:return-object="false"
								@update:model-value=" targetChangeDocumentType(record,this) "
								></v-combobox>
							</v-col>
						</v-row>	

					</div>

					<!-- FORM UNTUK PENCARIAN ASSET -->
					<div v-if="target_type == 'Asset' || target_type == 'Document' && target_type_document == 'Asset'">		
						<!-- ASSET TYPE -->
						<v-row v-if="target_unit.id != undefined" dense>
							<v-col cols="12">
								<v-combobox
								:items="target_asset_types" 
								label="Tipe Asset"
								v-model="target_type_key"
								:return-object="false"
								@update:model-value=" targetChangeType(this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- ASSET -->
						<v-row v-if="target_type_key != undefined && target_asset_slugs_combos != undefined && target_asset_slugs_combos.length > 0" dense>
							<v-col cols="6">
								<v-text-field
									label="Nama Asset"
									v-model="target_asset.name"
									:readonly="true"
								></v-text-field>
							</v-col>
							<v-col cols="6">
								<v-combobox
									:items="target_asset_slugs_combos" 
									label="Pilih Asset Slug"
									v-model="target_asset.slug"
									@update:model-value=" targetChangeAsset(record,this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- APABILA ASSET KOSONSG -->
						<v-row v-if="target_type_key != undefined && target_asset_slugs_combos != undefined && target_asset_slugs_combos.length <= 0" dense>
							<v-btn
								class="mt-2"
								color="teal-darken-4"
								block
								variant="flat"
								:disabled="true"
								>Asset Tidak Ditemukan</v-btn>
						</v-row>
					</div>

					<!-- APABILA ADA DOKUMEN -->
					<v-row v-if="target_documents != undefined && target_documents.length > 0" dense>
						<v-col cols="6">
							<v-text-field								
								label="Document Name"
								v-model="target_document.name"
								:readonly="true"
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
								:items="target_documents_ids_combos" 
								label="Pilih Document Id"
								v-model="target_document.id"
								@update:model-value=" targetChangeDocument(record,this) "
							></v-combobox>
						</v-col>
					</v-row>

					<!-- APABILA DOKUMEN KOSONG -->
					<v-row v-if="( target_type_document == 'Asset' && target_asset_slugs_combos != undefined && target_asset_slugs_combos.length > 0 && target_asset != undefined || target_type_document == 'Unit' ) && target_type == 'Document' && target_documents != undefined && target_documents.length <= 0" dense>
						<v-btn
							class="mt-2"
							color="teal-darken-4"
							block
							variant="flat"
							:disabled="true"
							>Dokumen Tidak Ditemukan</v-btn>
					</v-row>
					
				</div>

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-maintenance-create",
	components : {
	},
	data(){	
		return {
			target_unit  : {},
			target_asset : {},
			target_document : {},

			target_documents : undefined,
			target_documents_ids : undefined,
			target_documents_ids_combos : undefined,

			target_assets : undefined,
			target_asset_slugs : undefined,
			target_asset_slugs_combos : undefined,

			target_type : undefined,
			target_type_key : undefined,
			target_type_document : undefined,

			target_asset_types : undefined,
		}
	},
	methods : {

		addTargetAsset : function (data) {
			// prevent error
			for( let target of data.target_assets_needed ) {
				if(target.id == data.target_asset.id) return;
			}

			data.targets_assets_needed.push( data.target_asset );
		},
		addTargetDocument : function (data) {
			data.targets_documents_needed.push( data.target_document );
		},
		addtarget : function (data) {
			if ( data.target_type == 'Asset' ) {
				data.addTargetAsset(data);
			} else if ( data.target_type == 'Document' ) {
				data.addTargetDocument(data);
			}
		},

		getAssetType : function (data) {
			if ( data.assets_types ) 
				return data.getAssetList( record, data );	

			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => {
					data.target_asset_types = response;
				}
			);
		},
		getAssetList : function (data) {
			// reset every new asset list fetched
			data.target_asset = {};
			data.target_documents = [];

			// reset every new asset list fetched
			data.target_asset_slugs_combos = undefined;
			data.target_asset_slugs = undefined;
			data.target_assets = undefined;

			// fetch list asset
			this.$http(`infrastructure/api/ref-asset/${data.target_unit.id}/${data.target_type_key}/asset`).then(
				(response) => {
					data.target_asset_slugs_combos = response.assets_slugs_combos;
					data.target_asset_slugs = response.assets_slugs;
					data.target_assets = response.assets;
				}
			)
		},
		
		getDocumentsListByUnit : function (data) {
			if(data.target_unit.id == undefined) return;
			data.target_documents = [];

			this.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}`).then(
				(response) => {
					data.target_documents_ids_combos = response.documents_ids_combos;
					data.target_documents_ids = response.documents_ids;
					data.target_documents = response.documents;
				}
			)
		},	
		getDocumentsListByAsset : function (data) {
			if(data.target_asset.id == undefined) return;
			data.target_documents = [];

			this.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}/asset/${data.target_asset.id}`).then(
				(response) => {
					data.target_documents_ids_combos = response.documents_ids_combos;
					data.target_documents_ids = response.documents_ids;
					data.target_documents = response.documents;
				}
			)
		},	

		targetChangeDocumentType: function (record, data) {
			data.target_document = {};
			record.target = undefined;
			record.target_type = undefined;

			if( data.target_type_document == 'Asset' ){
				data.getDocumentsListByAsset(data);
			} else if( data.target_type_document == 'Unit' ) {
				data.getDocumentsListByUnit(data);
			}
		},

		targetChangeAsset : function (record,data) {
			data.target_asset = data.target_asset_slugs[ data.target_asset.slug ];

			// record target
			if(data.target_type == 'Asset'){
				record.target = data.target_asset;
				record.target_type = data.target_type;
			}

			if ( data.target_type_document == 'Asset' ) {
				data.getDocumentsListByAsset(data);
			}
		},
		targetChangeDocument : function (record,data) {
			data.target_document = data.target_documents_ids[data.target_document.id];

			// record target
			record.target = data.target_document;
			record.target_type = data.target_type;
		},
		targetChangeUnit : function (data, units) {
			data.target_unit = units[data.target_unit.slug];
			data.target_asset = {};
			data.getAssetType(data);
		},
		targetChangeType : function (data) {
			data.getAssetList(data);
		},		
	}
};
</script>
