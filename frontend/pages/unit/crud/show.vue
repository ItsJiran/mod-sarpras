<template>
	<form-show
		with-helpdesk hide-edit hide-delete
	>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							readonly
						></v-text-field>
					</v-col>
				</v-row>
			</v-card-text>
		</template>

		<template v-slot:info="{ theme }">

			<div class="text-overline mt-4">Aksi</div>
			<v-divider></v-divider>

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('asset')"
				>List Asset</v-btn
			>

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('document')"
				>List Documents</v-btn
			>

		</template>
	</form-show>
</template>

<script>
	export default {
		name: "infrastructure-unit-show",
		methods : {
			redirectPage : function ( name = '' ) {
				const current_route = this.$router.currentRoute._value;
				const current_route_name = current_route.name;
				
				let target_methods = ['show','create','delete','update'];
				let current_route_name_clean = current_route_name;

				for ( let method of target_methods )
					current_route_name_clean = current_route_name_clean.replaceAll(method,'');
				
				let redirect_to = current_route_name_clean + name;

				return this.$router.push({ name : redirect_to });
			}
		}
	};
</script>
