<template>
	<form-data v-if=" checkRoute('infrastructure-deadline') " hide-create>
		<template v-slot:forminfo></template>

		<template v-slot:helpdesk></template>

		<template v-slot:utility></template>
	</form-data>

	<form-data v-if=" !checkRoute('infrastructure-deadline') ">
		<template v-slot:forminfo></template>

		<template v-slot:helpdesk></template>

		<template v-slot:utility></template>
	</form-data>
</template>

<script>
export default {
	name: "infrastructure-record-data",
	methods : {
		checkRoute : function (name = "") {
			// route_name
			let route_name = this.$router.currentRoute._value.name;
			let methods = ['show','delete','update','edit','create'];

			for ( let method of methods ) 
				route_name = route_name.replaceAll('-' + method,'');
			
			return route_name == name;
		}
	}
};
</script>
