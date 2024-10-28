<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ record }">
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
						<v-textarea 
							label="Rincian" 
							v-model="record.description"
						></v-textarea>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-currency-field
							label="Harga Pembayaran"
							v-model="record.payprice"
						></v-currency-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-date-input
							label="Tanggal Pembayaran"
							v-model="record.paydate"
						></v-date-input>
					</v-col>
				</v-row>

				<v-row dense>
					<v-file-input 
						label="Gambar Bukti" 
						v-model="record.proof_img"
						@update:model-value="changeImg(record, this)"
					></v-file-input>
				</v-row>

				<v-row dense>
					<v-img 
						:src="blob_path" 
						aspect-ratio="16/9" 
						cover 
					/>
				</v-row>				

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-record-create",
	data: () => {
		return {
			blob_path: '',
		}
	},
	methods: {
		changeImg: (record, data) => {
			const url = URL.createObjectURL(record.proof_img);
			data.blob_path = url;
			console.log(data.blob_path, url);
		}
	}
};
</script>
