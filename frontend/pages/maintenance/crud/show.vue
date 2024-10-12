<template>
	<form-show
		with-helpdesk
	>
		<template v-slot:default="{ 
			combos : { 
				morph_type, 
				morph_type_keys, 
				types, 
				types_documents, 
				units, 
				units_slug 
			},
			record
			}">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							readonly
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

				<!-- INIT SHOW PROPERTIES -->
				<div v-if="!initShow">
					{{ initShowProperties( this, record, { 
						morph_type, 
						morph_type_keys, 
						types, 
						types_documents, 
						units, 
						units_slug 
					}) }}
				</div>

				<div v-if="initShow" class="px-2 py-2">

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
		initShowProperties : function ( data, record, combos ) {
			console.log('test');
			console.log(combos);
			data.initShow = true;
		}
	}
};
</script>
