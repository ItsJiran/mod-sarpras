<template>

	<div class="text-overline mt-6">Informasi Elektronik</div>
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
            <v-number-input
            label="Jumlah Barang"
            v-model="record.jumlah"
			:readonly="true"
            :min="0"
            ></v-number-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Spesifikasi"
				v-model="record.spesifikasi"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-show-electronic",
	props: ['record'],
};
</script>
