<template>
    <div>
        <div class="flex gap-4">
            <div class="flex-grow p-4 pl-0">
                <div class="mb-4 border-b dark:border-gray-600">
                    <h2 class="text-xl font-bold mb-4" v-html="fieldValue.name"></h2>
                </div>
                <div class="min-h-[100px]">
                    <h3 class="text-md font-semibold mb-2 pb-2">Description</h3>
                    <div v-html="fieldValue.description"></div>
                </div>




                    <div>
                        <div class="border-b border-gray-300">
                            <nav class="flex" aria-label="Tabs">
                                <a
                                    v-for="(tab, index) in tabs"
                                    :key="index"
                                    class="flex-grow text-center whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                    :class="[
              tab === activeTab
                ? 'border-indigo-500 text-indigo-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
                                    @click="activeTab = tab"
                                    href="#"
                                >
                                    {{ tab }}
                                </a>
                            </nav>
                        </div>




                    <div class="p-6">
                        <div v-if="activeTab === 'Tab 1'">Content for Tab 1</div>
                        <div v-if="activeTab === 'Tab 2'">Content for Tab 2</div>
                        <div v-if="activeTab === 'Tab 3'">Content for Tab 3</div>
                    </div>
                </div>






            </div>
            <div class="w-88 pt-4">
                <div class="h-screen border-l dark:border-gray-600 p-4 pl-6">
                    Колонка 2: Ширина примерно 352px
                </div>
            </div>
        </div>
        {{ fieldValue }}
    </div>


</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    data() {
        return {
            activeTab: 'Tab 1',
            tabs: ['Tab 1', 'Tab 2', 'Tab 3']
        }
    },
    computed: {
        fieldValue() {
            return this.field.displayedAs || this.field.value
        },
    }
}
</script>
