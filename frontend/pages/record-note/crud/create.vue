<template>
	<form-create with-helpdesk hide-save>
		<template v-slot:toolbar="{ record, store }">
			<v-btn @click="saveRecord(record,store)" icon>
				<v-icon>
					save
				</v-icon>
			</v-btn>
		</template>

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
						<v-textarea x
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
					<v-img v-if="blob_path != undefined && blob_path != ''"
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
	name: "infrastructure-record-note-create",
	data: () => {
		return {
			blob_path: '',
		}
	},
	methods: {
		changeImg: (record, data) => {
			if(record.proof_img == '' || record.proof_img == undefined){
				data.blob_path = '';				
			} else {
				const url = URL.createObjectURL(record.proof_img);			
				data.blob_path = url;
			}
		},
		saveRecord: function (record, store) {
			let currentRoute = this.$router.currentRoute._value.href;
			let currentName = this.$router.currentRoute._value.name;

			currentRoute = currentRoute.replace('/create','');
			currentRoute = currentRoute.substring(1);
			currentRoute = currentRoute.replace('infrastructure/','infrastructure/api/');

			this.$http(currentRoute, {
				method: "POST",
				params: record,
				contentType: "multipart/form-data",
			})
			.then((response) => {
                store.openFormData();

                store.snackbar.color = "green";
                store.snackbar.text = `tambah data ${store.pageKey} berhasil`;
                store.snackbar.state = true;
			});
		}
	}
};
</script>
