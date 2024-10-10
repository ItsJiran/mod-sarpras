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
			</v-card-text>

			<!-- LIST TABLE UNTUK PENCARIAN ASSET -->
			<div class="text-overline mt-6">List Asset Yang Dibutuhkan</div>
			<v-divider :thickness="3" class="mt-3 mb-6" />
			<v-table>
				<thead>
					<tr>
						<th class="text-center">
							Nama 
						</th>
						<th class="text-center">
							Tipe
						</th>
						<th class="text-center">
							Unit Terkait	
						</th>
						<th class="text-center">
							Bekukan Target Terkait	
						</th>
						<th class="text-center">
							Operasi	
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="additionals_assets_needed.length > 0" v-for="item in additionals_assets_needed" :key="item.name">

					</tr>
				</tbody>
			</v-table>
		
			<v-btn v-if="additionals_assets_needed.length <= 0"
				class="mt-2 w-full"
				color="teal-darken-4"
				block
				variant="flat"
				:disabled="true"
			>Tidak Ada Assets Yang Dibutuhkan</v-btn>

			<!-- LIST TABLE UNTUK PENCARIAN DOCUMENT -->
			<div class="text-overline mt-6">List Document Yang Dibutuhkan</div>
			<v-divider :thickness="3" class="mt-3 mb-6" />
			<v-table>
				<thead>
					<tr>
						<th class="text-center">
							Nama 
						</th>
						<th class="text-center">
							Tipe
						</th>
						<th class="text-center">
							Unit Terkait	
						</th>
						<th class="text-center">
							Asset Terkait	
						</th>
						<th class="text-center">
							Bekukan Target Terkait	
						</th>
						<th class="text-center">
							Operasi	
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="additionals_documents_needed.length > 0" v-for="item in additionals_documents_needed" :key="item.name">

					</tr>
				</tbody>
			</v-table>
			<v-btn v-if="additionals_documents_needed.length <= 0"
				class="mt-2 w-full"
				color="teal-darken-4"
				block
				variant="flat"
				:disabled="true"
			>Tidak Ada Dokumen Yang Dibutuhkan</v-btn>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-record-create",
};
</script>
