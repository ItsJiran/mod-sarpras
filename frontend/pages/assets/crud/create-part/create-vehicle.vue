<template>
	<v-row dense>
		<v-col cols="6">
			<v-text-field
				label="Harga Dapat"
				v-model="record.receive_price"
			></v-text-field>
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
</template>

<script>
export default {
	name: "infrastructure-assets-create-vehicle",
	props: ['record'],
};
</script>
