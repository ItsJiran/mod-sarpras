<template v-slot:default="{ 
	record,
 }">
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

	<div class="text-overline mt-6">Informasi Tanah</div>
	<v-divider :thickness="3" class="mt-3 mb-6" />

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Atas Nama"
				v-model="record.atas_nama"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Nop Tanah"
				v-model="record.nop"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="6">
			<v-text-field
				label="Luas Tanah Bumi"
				v-model="record.luas_bumi"
				:readonly="true"
			></v-text-field>
		</v-col>
		<v-col cols="6">
			<v-text-field
				label="Luas Tanah Bangunan"				
				v-model="record.luas_bangunan"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="6">
			<v-text-field
				label="Njop Tanah Bumi"
				v-model="record.njop_bumi"
				:readonly="true"
			></v-text-field>
		</v-col>
		<v-col cols="6">
			<v-text-field
				label="Njop Tanah Bangunan"				
				v-model="record.njop_bangunan"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Alamat Wajib Pajak"
				v-model="record.alamat_wajib_pajak"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Alamat Objek Pajak"
				v-model="record.alamat_objek_pajak"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-show-land",
	props: ['record'],
};
</script>
