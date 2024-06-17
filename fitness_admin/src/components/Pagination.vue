<template>
    <div class="block-pagination" v-if="pagination.total > 0 & pagination.last_page > 1">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center gap-2">
                <li 
                    v-for="page in pagination.links"
                    class="page-item" :class="{'active': page.active}" 
                >
                    <router-link 
                        v-if="page.label.includes('Next') && Number(pagination.current_page) < Number(pagination.last_page)"
                        :to="`/${to}?page=${pagination.current_page + 1}${searchValue ? `&search=${searchValue}` : '' }`" 
                        class="page-link shadow-none"
                    >
                        >
                    </router-link>
                    <router-link 
                        v-else-if="page.label.includes('Previous') && Number(pagination.current_page) > 1"
                        :to="`/${to}?page=${pagination.current_page - 1}${searchValue ? `&search=${searchValue}` : '' }`" 
                        class="page-link shadow-none"
                    >
                        <
                    </router-link>
                    <router-link 
                        v-else-if="!page.label.includes('Previous') && !page.label.includes('Next')" 
                        :to="`/${to}?page=${page.label}${searchValue ? `&search=${searchValue}` : '' }`" 
                        class="page-link shadow-none"
                    >
                        {{page.label}}
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
    import { computed, defineProps } from "vue";
    import { useRoute } from "vue-router";

    const props = defineProps({
        pagination: Object,
        to: {
            type: String,
            default: '',
        }
    });

    const route = useRoute();

    const searchValue = computed(() => route.query.search);
</script>

<style lang="scss">
.page-item{
    &:not(.active){
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }

    .page-link{
        border-radius: 5px;
        color: #5932EA;
        font-weight: 500;
    }

    &.active{
        .page-link{
            background: #5932EA;
            border-color: #5932EA;
            color: #FFF;
        }
    }
}
</style>