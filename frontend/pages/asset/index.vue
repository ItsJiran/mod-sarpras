<template>		
	<page-crud v-if=" checkRoute('infrastructure-asset') "
		page-name="infrastructure-asset"
		page-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset') "	
		page-name="infrastructure-unit-asset"
		page-key="asset"
		parent-name="infrastructure-unit"
		parent-key="unit"
	></page-crud>
</template>

<script>
export default {
	name: "infrastructure-asset",
	methods:{
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
