<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ 
			combos: { statuses },
			record,
			store, 
			}">
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
					<v-combobox
					v-if="statuses != undefined"
					:items="statuses.store" 
					:return-object="false"
					label="Status"
					v-model="record.status"			
					></v-combobox>
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
					<v-img v-if="record.proof_img_path != undefined && record.proof_img_path != ''"
						:src="record.proof_img_path" 
						aspect-ratio="16/9" 
						cover 
					/>
				</v-row>				

			</v-card-text>
		</template>
	</form-edit>
</template>

<script>
export default {
	name: "infrastructure-record-edit",
	data: () => {
		return {
		}
	},
	methods: {
		changeImg: (record, data) => {
			if(record.proof_img == '' || record.proof_img == undefined){
				record.proof_img_path = '';				
			} else {
				const url = URL.createObjectURL(record.proof_img);			
				record.proof_img_path = url;
			}
		}
	}
};
</script>
