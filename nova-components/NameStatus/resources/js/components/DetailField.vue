<template>
  <PanelItem :index="index" :field="field" />
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    computed: {
        fieldValue() {
            return this.field.displayedAs || this.field.value
        },
    }
}
</script>
