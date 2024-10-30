<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ 
			combos: { statuses },
			record,
			store, 
			}">
			<v-card-text>
				<div v-if="record != undefined && !init">
					{{ checkIsDraft(record, this) }}					
				</div>

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

				<div class="text-overline mt-6">Bukti pembayaran :</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

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
				
				<div class="text-overline mt-6">Dibuat oleh :</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row v-if="record.user != undefined" dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.user.name"
							:readonly="true"
						></v-text-field>
					</v-col>
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
			init : false,
		}
	},
	methods: {
		changeImg : (record, data) => {
			if(record.proof_img == '' || record.proof_img == undefined){
				record.proof_img_path = '';				
			} else {
				const url = URL.createObjectURL(record.proof_img);			
				record.proof_img_path = url;
			}
		},
		checkIsDraft : function (record, data) {
			const current_route = this.$router.currentRoute._value;
			data.init = true;
			console.log(current_route, this);
		},
	}
};
</script>
