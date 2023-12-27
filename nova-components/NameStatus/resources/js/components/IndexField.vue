<template>
    <span class="text-with-line"
          :style="{ borderLeftColor: fieldValue.priority.color }"
          :title="fieldValue.priority.name">
        {{ fieldValue.name }}
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    computed: {
        fieldValue() {
            return this.field.displayedAs || this.field.value
        },
    }
}
</script>

<style scoped>
.text-with-line {
    border-left-width: 4px;
    border-left-style: solid;
    padding-left: 10px;
}
</style>
