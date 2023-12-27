<template>
    <span class="nova-badge" :style="{ backgroundColor: fieldValue.color }">
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
.nova-badge {
    display: inline-block;
    padding: 0.2em 0.6em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}
</style>
