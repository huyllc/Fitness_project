<template>
    <PageLayout :pageClass="pageClass">
        <Header :headerClass="headerClass"/>
        <main class="page-main flex-grow-1">
            <slot />
        </main>
        <Footer />
        <BlockToast 
            :title="toast.title" 
            :text="toast.content" 
            :show="toast.show"
            :type="toast.type"
        />
    </PageLayout>
</template>

<script setup>
import PageLayout from './PageLayout.vue'
import Header from '@/components/common/Header.vue'
import Footer from '@/components/common/Footer.vue'
import BlockToast from '@/components/BlockToast.vue'
import { computed } from 'vue'
import { useStore } from 'vuex'

const store = useStore()
const props = defineProps({
    headerClass: {
        type: String,
        default: ''
    },
    pageClass: {
        type: String,
        default: ''
    }  
})
const toast = computed(() => store.getters.getToast)

</script>