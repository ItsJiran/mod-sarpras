<template>
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
			<v-text-field
				label="Lokasi Terakhir"
				v-model="record.last_location"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>
</template>

<script>
export default {
	name: "infrastructure-unit-asset-show-electronic",
	props: ['record'],
};
</script>
