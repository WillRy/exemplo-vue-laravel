<template>
    <div>
        <Indicativos/>
    </div>
</template>

<script>
import Dashboard from "../Layouts/Dashboard";
import Indicativos from "../components/dashboard/Indicativos";

export default {
    name: "Dashboard",
    components: {Indicativos},
    layout: Dashboard
}
</script>

<style scoped>

</style>
