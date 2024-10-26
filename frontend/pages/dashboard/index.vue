<template>
    <page-home
        page-name="infrastructure-dashboard"
        page-title="Untitled"
    >
    <template v-slot:toolbar>
        <v-btn icon>
            <v-icon>
                home
            </v-icon>
        </v-btn>
    </template>
        <template v-slot:default></template>
    </page-home>
</template>

<script>
    export default {
        name: "infrastructure-dashboard",
    };
</script>
