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

				<v-stepper v-if="record != undefined && record.status_step != undefined" :model-value="record.status_step" class="mb-6" alt-labels>
					<v-stepper-header>
						<v-stepper-item title="Draft" value="1"></v-stepper-item>

						<v-divider></v-divider>

						<v-stepper-item title="Pending" value="2"></v-stepper-item>

						<v-divider></v-divider>

						<v-stepper-item :title="record.status_step == 3 ? record.status : 'Confirmed'" value="3"></v-stepper-item>
					</v-stepper-header>
				</v-stepper>

				<div class="text-overline mt-6">Data :</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-text-field 
							label="Name" 
							v-model="record.name"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-textarea 
							label="Rincian" 
							v-model="record.description"
							:readonly="true"
						></v-textarea>
					</v-col>
				</v-row>

				<!-- <v-row v-if="record != undefined && record.is_admin == true" dense>
					<v-combobox
					v-if="statuses != undefined"
					:items="statuses.store" 
					:return-object="false"
					label="Status"
					v-model="record.status"			
					:readonly="true"
					></v-combobox>
				</v-row> -->

				<v-row dense>
					<v-col cols="12">
						<v-currency-field
							label="Harga Pembayaran"
							v-model="record.payprice"
							:readonly="true"
						></v-currency-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-date-input
							label="Tanggal Pembayaran"
							v-model="record.paydate"
							:readonly="true"
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

		<template v-slot:helpdesk="{ theme, record, store }">

				<v-btn v-if="record != undefined && record.status == 'pending'"
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="convertToDraft(record,this)"
				>Ubah Ke Draft</v-btn>			

				<v-btn v-if="record != undefined && record.status == 'draft'"
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="convertToPending(record,this)"
				>Ubah Ke Pending</v-btn>

		</template>
	</form-show>
</template>

<script>
export default {
	name: "infrastructure-record-show",
	methods : {
		convertToPending : function (record,data) {
			console.log('pending is clicked');
		},
		convertToDraft : function (record,data) {
			console.log('draft is clicked');
		}
	},
};
</script>
