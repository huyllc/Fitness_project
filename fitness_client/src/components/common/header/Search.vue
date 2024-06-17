<template>
    <div class="block-search" :class="{'is-show': isShowSearch}">
        <form class="form-group w-100 d-flex gap-2" method="POST" @submit.prevent="search">
            <div class="input-group">
                <input type="text" class="form-control input-search p-0 bg-transparent border-0 shadow-none" placeholder="search here!" v-model="query">
                <span class="search-icon input-group-text border-0">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19.343C15.4183 19.343 19 15.7613 19 11.343C19 6.92474 15.4183 3.34302 11 3.34302C6.58172 3.34302 3 6.92474 3 11.343C3 15.7613 6.58172 19.343 11 19.343Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21.343L16.65 16.993" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <button type="submit" class="d-none d-sm-block btn-search text-white fw-bold border-0">Search</button>
            <button type="button" class="d-sm-none btn-search text-white fw-bold border-0" @click="toggleSearch">Close</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
    const query = ref("")
    const emit = defineEmits(['toggle-search'])
    const router = useRouter()
    const props = defineProps({
        isShowSearch: {
            type: Boolean,
            default: false
        }
    })
    const toggleSearch = () => {
        emit('toggle-search');
    }
    const search = async () => {
        if (!query.value) {
            return
        }
        router.push({path: '/search', query: { search: query.value }})
    }
</script>

<style lang="scss">
.page-header{
    .input-group{
        border-radius: 30px;
        overflow: hidden;
        padding: 0 13px;
        background: #D9D9D9;
    }

    .input-search{
        height: 30px;
    }

    .input-group-text{
        padding: 0;
        background: transparent;
    }

    .btn-search{
        background: #D43B3B;
        font-size: 14px;
        border-radius: 30px;
        padding: 0 11px;
        height: 30px;
    }
}

@media (max-width: 575px){
    .page-header{
        .block-search{
            position: fixed;
            top: 0;
            bottom: 0;
            left: -150%;
            width: 100%;
            z-index: 40;
            background: black;
            padding: 20px;
            transition: all 0.35s ease;

            &.is-show{
                left: 0;
            }
        }

    }
}
</style>