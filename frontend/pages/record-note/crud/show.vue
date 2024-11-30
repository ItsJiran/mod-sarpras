<template>

	<form-show with-helpdesk hide-edit>
		<template v-slot:toolbar="{ record, store }">
			<v-btn icon v-if="record.status_step == '1' && record.is_creator">
				<v-icon @click="redirectPage( 'edit' )">
					edit
				</v-icon>
			</v-btn>
		</template>

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

		<template v-slot:info="{ theme, record, store }">		

			<v-btn v-if="record != undefined && record.is_creator && record.status == 'pending' && record.status_step != 3"
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="convertToDraft(record,this)"
			>Ubah Ke Draft</v-btn>			

			<v-btn v-if="record != undefined && ( record.is_admin || record.is_verificator ) && record.status_step != 3 && record.status_step == 2"
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="convertToVerified(record,this)"
			>Ubah Ke Verified</v-btn>

			<v-btn v-if="record != undefined && ( record.is_admin || record.is_verificator ) && record.status_step != 3 && record.status_step == 2"
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="convertToUnVerified(record,this)"
			>Ubah Ke UnVerified</v-btn>

			<v-btn v-if="record != undefined && record.is_creator && record.status == 'draft' && record.status_step != 3"
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="convertToPending(record,this)"
			>Ubah Ke Pending</v-btn>

			<v-btn v-if="record != undefined && record.is_creator && record.status_step != 3"
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="convertToCancelled(record,this)"
			>Ubah Ke Cancelled</v-btn>

			<v-spacer></v-spacer>

			<v-btn
			class="mt-3"
			:color="theme"
			block
			variant="flat"
			@click="redirectPage('used')"
			>Lihat Yang Digunakan</v-btn>

		</template>
	</form-show>
</template>

<script>
export default {
	name: "infrastructure-record-note-show",
	methods : {
		redirectPage : function ( name = '' ) {
			const current_route = this.$router.currentRoute._value;
			const current_route_name = current_route.name;
			
			let target_methods = ['show','create','delete','edit'];
			let current_route_name_clean = current_route_name;

			for ( let method of target_methods )
				current_route_name_clean = current_route_name_clean.replaceAll(method,'');
			
			let redirect_to = current_route_name_clean + name;
			return this.$router.push({ name : redirect_to });
		},
		convertToDraft : function (record,data) {
			console.log('draft is clicked');
			const route_params = this.$router.currentRoute._value.params;
			console.log(route_params);

			this.$http(`infrastructure/api/record/`+route_params['record']+'/note/'+route_params['note']+'/draft', {
                method: "POST",
            }).then((response) => {
                if(response.success && response.record){					
					record.status = response.record.status;
					record.status_step = response.record.status_step;
				}
            });	
			
		},
		convertToPending : function (record,data) {
			console.log('pending is clicked');
			const route_params = this.$router.currentRoute._value.params;
			console.log(route_params);

			this.$http(`infrastructure/api/record/`+route_params['record']+'/note/'+route_params['note']+'/pending', {
                method: "POST",
            }).then((response) => {
                if(response.success && response.record){
					record.status = response.record.status;
					record.status_step = response.record.status_step;
				}
            });
		},
		convertToVerified : function (record,data) {
			console.log('verified is clicked');
			const route_params = this.$router.currentRoute._value.params;

			this.$http(`infrastructure/api/record/`+route_params['record']+'/note/'+route_params['note']+'/verified', {
                method: "POST",
            }).then((response) => {
                if(response.success && response.record){
					record.status = response.record.status;
					record.status_step = response.record.status_step;
				}
            });

		},
		convertToUnVerified : function (record,data) {
			console.log('unverified is clicked');
			const route_params = this.$router.currentRoute._value.params;

			this.$http(`infrastructure/api/record/`+route_params['record']+'/note/'+route_params['note']+'/unverified', {
                method: "POST",
            }).then((response) => {
                if(response.success && response.record){
					record.status = response.record.status;
					record.status_step = response.record.status_step;
				}
            });
		},
		convertToCancelled : function (record,data) {
			console.log('cancelled is clicked');
			const route_params = this.$router.currentRoute._value.params;

			this.$http(`infrastructure/api/record/`+route_params['record']+'/note/'+route_params['note']+'/cancelled', {
                method: "POST",
            }).then((response) => {
                if(response.success && response.record){
					record.status = response.record.status;
					record.status_step = response.record.status_step;
				}
            });

		},
		getImage : function(record) {
			this.$http(record.proof_img_path, {
                method: "GET",
            }).then((response) => {
				console.log(response);
            });
		}
	},
};
</script>
