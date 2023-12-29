<template>
    <div class="text-with-line"
         :style="{ borderLeftColor: fieldValue.priority.color,
                    '-webkit-mask-image': textExceeds ? maskImage : 'none',
                    'mask-image': textExceeds ? maskImage : 'none' }"
         :title="fieldValue.name"
         ref="textElement">
        {{ fieldValue.name }}
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    data() {
        return {
            textExceeds: false,
            maskImage: 'linear-gradient(to right, black 90%, transparent 100%)'
        }
    },

    computed: {
        fieldValue() {
            return this.field.displayedAs || this.field.value
        },
    },

    mounted() {
        this.checkTextWidth();
    },

    methods: {
        checkTextWidth() {
            const element = this.$refs.textElement;
            if (element.scrollWidth > element.offsetWidth) {
                this.textExceeds = true;
            }
        }
    }
}
</script>

<style scoped>
.text-with-line {
    border-left-width: 4px;
    border-left-style: solid;
    padding-left: 10px;
    width: max-content;
    max-width: 300px;
    overflow: hidden;
    position: relative;
}
</style>