<template>
    <div>

    </div>
</template>

<script>
    import AppStorage from "../../Helpers/AppStorage";
    export default {
        created() {
            AppStorage.clear()
            Toast.fire({
                icon: 'success',
                title:   'خروج موفقیت آمیز بود'
            })
            this.$router.push({name: '/'})
        }
    }
</script>

<style>

</style>
