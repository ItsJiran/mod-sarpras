<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { morph_type, morph_type_keys, types, units, units_slug },
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

				<div class="text-overline mt-6">Asset dan Dokumen Yang Dibutuhkan</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<div class="px-2 py-2">

					<v-row dense>
						<v-col cols="6">
							<v-text-field
								label="Nama Unit"
								v-model="additional_unit.name"
								:readonly="true"
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="units_slug" 
							label="Slug Unit"
							v-model="additional_unit.slug"
							:return-object="false"
							@update:model-value=" additionalChangeUnit(this,units) "
							></v-combobox>
						</v-col>
					</v-row>

					<v-row dense>
						<v-col cols="12">
							<v-combobox
							:items="morph_type_keys" 
							label="Tipe Tujuan"
							v-model="additional_type"
							:return-object="false"
							></v-combobox>
						</v-col>
					</v-row>

					<!-- FORM UNTUK PENCARIAN ASSET -->
					<div v-if="additional_type == 'Asset'">		

						<!-- ASSET TYPE -->
						<v-row v-if="additional_unit.id != undefined" dense>
							<v-col cols="12">
								<v-combobox
								:items="additional_asset_types" 
								label="Tipe Asset"
								v-model="additional_type_key"
								:return-object="false"
								@update:model-value=" additionalChangeType(this) "
							></v-combobox>
							</v-col>
						</v-row>

						<!-- ASSET -->
						<v-row v-if="additional_type_key != undefined && additional_asset_slugs_combos != undefined && additional_asset_slugs_combos.length > 0" dense>
							<v-col cols="6">
								<v-text-field
									label="Nama Asset"
									v-model="additional_asset.name"
									:readonly="true"
								></v-text-field>
							</v-col>
							<v-col cols="6">
								<v-combobox
									:items="additional_asset_slugs_combos" 
									label="Pilih Asset Slug"
									v-model="additional_asset.slug"
									@update:model-value=" additionalChangeAsset(this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- APABILA ASSET KOSONSG -->
						<v-row v-if="additional_type_key != undefined && additional_asset_slugs_combos != undefined && additional_asset_slugs_combos.length <= 0" dense>
							<v-btn
								class="mt-2"
								color="teal-darken-4"
								block
								variant="flat"
								:disabled="true"
								>Tidak Ditemukan</v-btn>
						</v-row>

					</div>

					<!-- FORM UNTUK PENCARIAN DOKUMEN PADA ASSET -->
					<div v-if="additional_type == 'Document'">

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
			additional_unit  : {},
			additional_asset : {},

			additional_asset : {},
			additional_assets : undefined,
			additional_asset_slugs : undefined,
			additional_asset_slugs_combos : undefined,

			additional_type : undefined,
			additional_type_key : undefined,

			additional_asset_types : undefined,
		}
	},
	methods : {

		getAssetType : function (data) {
			if ( data.assets_types ) 
				return data.getAssetList( record, data );	

			this.$http(`infrastructure/api/ref-asset/type`).then(
				(response) => {
					data.additional_asset_types = response;
				}
			);
		},
		getAssetList : function (data) {
			// reset every new asset list fetched
			data.additional_asset_slugs_combos = undefined;
			data.additional_asset_slugs = undefined;
			data.additional_assets = undefined;

			// fetch list asset
			this.$http(`infrastructure/api/ref-asset/${data.additional_unit.id}/${data.additional_type_key}/asset`).then(
				(response) => {
					data.additional_asset_slugs_combos = response.assets_slugs_combos;
					data.additional_asset_slugs = response.assets_slugs;
					data.additional_assets = response.assets;
				}
			)
		},

		additionalChangeAsset : function (data) {
			data.additional_asset = data.additional_asset_slugs[ data.additional_asset.slug ];			
		},

		additionalChangeUnit : function (data, units) {
			data.additional_unit = units[data.additional_unit.slug];
			data.additional_asset = {};
			data.getAssetType(data);
		},

		additionalChangeType : function (data) {
			data.getAssetList(data);
		},		
	}
};
</script>
