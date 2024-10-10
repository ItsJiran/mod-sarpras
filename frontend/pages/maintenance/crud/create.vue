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
								@update:model-value=" targetChangeDocumentType(this) "
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
									@update:model-value=" targetChangeAsset(this) "
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
								>Tidak Ditemukan</v-btn>
						</v-row>
					</div>

					
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
			targets_assets_needed : [],
			targets_documents_needed : [],

			target_unit  : {},
			target_asset : {},
			target_document : {},

			target_documents : undefined,
			target_documents_slugs : undefined,

			target_assets : undefined,
			target_asset_slugs : undefined,
			target_asset_slugs_combos : undefined,
			additonal_documents : undefined,

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
			this.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}`).then(
				(response) => {
					console.log(response);
				}
			)
		},	
		getDocumentsListByAsset : function (data) {
			if(data.target_asset.id == undefined) return;

			is.$http(`infrastructure/api/ref-document/combos/unit/${data.target_unit.id}/asset/${data.target_asset.id}`).then(
				(response) => {
					console.log(response);
				}
			)
		},	

		targetChangeDocumentType: function (data) {
			if( data.target_type_document == 'Asset' ){
				data.getDocumentsListByAsset(data);
			} else if( data.target_type_document == 'Unit' ) {
				data.getDocumentsListByUnit(data);
			}
		},

		targetChangeAsset : function (data) {
			data.target_asset = data.target_asset_slugs[ data.target_asset.slug ];			
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
