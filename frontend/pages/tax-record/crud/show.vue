<template>
	<form-show
		with-helpdesk
	>
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


				<div class="text-overline mt-6">Bukti pembayaran :</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-img
						:src="record.proof_img_path" 
						aspect-ratio="16/9" 
						cover 
					/>
				</v-row>	

				<div class="text-overline mt-6">Dibuat oleh :</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.user.name"
						></v-text-field>
					</v-col>
				</v-row>
				
			</v-card-text>
		</template>

		<template v-slot:helpdesk></template>
	</form-show>
</template>

<script>
export default {
	name: "infrastructure-record-show",
};
</script>
