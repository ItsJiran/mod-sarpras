<template>
	<form-show
		with-helpdesk
	>
		<template v-slot:default="{ 
			record,
			combos : { 
				morph_type, 
				morph_type_keys, 
				types, 
				types_documents, 
				units, 
				units_slug 
			},
			}">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Deskripsi"
							:readonly="true"
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
							:readonly="true"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>


				<v-row v-if="record.type != undefined && record.type == 'berkala'" dense>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Hari"
						v-model="record.period_number_day"
							:readonly="true"
						:min="0"
						></v-number-input>
					</v-col>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Bulan"
						v-model="record.period_number_month"
							:readonly="true"
						:min="0"
						></v-number-input>
					</v-col>
					<v-col cols="4">
						<v-number-input
						label="Jumlah Tahun"
						v-model="record.period_number_year"
							:readonly="true"
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
							:readonly="true"
						></v-date-input>
					</v-col>
				</v-row>

				<div class="text-overline mt-6">Form Pencarian Asset atau Dokumen Yang Terhubung</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<div v-if="record != undefined && record.target != undefined" class="px-2 py-2">

					<v-row dense>
						<v-col cols="6">
							<v-text-field
								label="Nama Unit"
								v-model="record.target_unit.name"
								:readonly="true"
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="units_slug" 
							label="Slug Unit"
							v-model="record.target_unit.slug"
							:return-object="false"
							:readonly="true"
							></v-combobox>
						</v-col>
					</v-row>

					<v-row dense>
						<v-col cols="12">
							<v-combobox
							label="Tipe Tujuan"
							v-model="record.target_type"
							:return-object="false"
							:readonly="true"
							></v-combobox>
						</v-col>
					</v-row>

					<!-- FORM UNTUK PENCARIAN DOKUMEN PADA DOCUMENT -->
					<div v-if="record.target_type == 'Document'">
						<!-- DOCUMENT -->
						<v-row dense>
							<v-col cols="12">
								<v-combobox
								label="Tipe Dokumen Terhubung Ke Mana"
								v-model="record.target_type_document"
								:return-object="false"
								:readonly="true"
								></v-combobox>
							</v-col>
						</v-row>
					</div>

					<!-- FORM UNTUK PENCARIAN ASSET -->
					<div v-if="record.target_type == 'Asset' || record.target_type == 'Document' && record.target_type_document == 'Asset'">		
						<!-- ASSET TYPE -->
						<v-row dense>
							<v-col cols="12">
								<v-combobox
								label="Tipe Asset"
								v-model="record.target_type_key"
								:return-object="false"
								:readonly="true"
								@update:model-value=" targetChangeType(this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- ASSET -->
						<v-row dense>
							<v-col cols="6">
								<v-text-field
									label="Nama Asset"
									v-model="record.target_asset.name"
									:readonly="true"
								></v-text-field>
							</v-col>
							<v-col cols="6">
								<v-combobox									 
									label="Pilih Asset Slug"
									v-model="record.target_asset.slug"
									:readonly="true"
									@update:model-value=" targetChangeAsset(record,this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- APABILA ADA DOKUMEN -->
						<v-row v-if='record.target_document != undefined' dense>
							<v-col cols="6">
								<v-text-field								
									label="Document Name"
									v-model="record.target_document.name"
									:readonly="true"
								></v-text-field>
							</v-col>
							<v-col cols="6">
								<v-combobox
									label="Pilih Document Id"
									v-model="record.target_document.id"
									:readonly="true"
									@update:model-value=" targetChangeDocument(record,this) "
								></v-combobox>
							</v-col>
						</v-row>

						<!-- APABILA ADA DOKUMEN -->


					</div>

				</div>

			</v-card-text>
		</template>

		<template v-slot:helpdesk></template>
	</form-show>
</template>

<script>
export default {
	name: "infrastructure-maintenance-show",
	data(){	
		return {
			initShow : false,

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
	
	}
};
</script>
