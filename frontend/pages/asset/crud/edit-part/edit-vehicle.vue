<template>
	
	<div class="text-overline mt-6">Informasi Kendaraan</div>
	<v-divider :thickness="3" class="mt-3 mb-6" />

	<v-row dense>
		<v-col cols="6">
			<v-currency-field
				label="Harga Dapat"
				v-model="record.receive_price"
			></v-currency-field>
		</v-col>
		<v-col cols="6">
			<v-date-input
				label="Tanggal Dapat"
				v-model="record.receive_date"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-currency-field
				label="Harga Jual"
				v-model="record.sale_price"
			></v-currency-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-date-input
				label="Tanggal Produksi"
				v-model="record.production_date"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Lokasi Terakhir"
				v-model="record.last_location"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Brand Kendaraan"
				v-model="record.brand"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Orang Yang Bertanggung Jawab"
				v-model="record.pic"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Nomor Polisi"
				v-model="record.no_pol"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-edit-vehicle",
	props: ['record'],
};
</script>
