<template>
	
	<div class="text-overline mt-6">Informasi Kendaraan</div>
	<v-divider :thickness="3" class="mt-3 mb-6" />

	<v-row dense>
		<v-col cols="6">
			<v-currency-field
				label="Harga Dapat"
				v-model="record.receive_price"
				:readonly="true"
			></v-currency-field>
		</v-col>
		<v-col cols="6">
			<v-date-input
				label="Tanggal Dapat"
				v-model="record.receive_date"
				:readonly="true"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-currency-field
				label="Harga Jual"
				v-model="record.sale_price"
				:readonly="true"
			></v-currency-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-date-input
				label="Tanggal Produksi"
				v-model="record.production_date"
				:readonly="true"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Lokasi Terakhir"
				v-model="record.last_location"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Brand Kendaraan"
				v-model="record.brand"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Orang Yang Bertanggung Jawab"
				v-model="record.pic"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Nomor Polisi"
				v-model="record.no_pol"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-show-vehicle",
	props: ['record'],
};
</script>
