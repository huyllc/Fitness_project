<template>
    <header class="page-header" :class="{ 'bg-theme-dark': isBgDark, [headerClass]: !isBgDark }">
        <div class="header-wrap app-container">
            <slot />
            <div class="row align-items-center" v-if="!isHeaderAuth">
                <div class="col-3 col-md-3 col-lg-3 col-left">
                    <Logo />
                </div>
                <div class="col-7 col-md-6 col-lg-4 col-center">
                    <Search :isShowSearch="isShowSearch" @toggle-search="toggleSearch"/>
                </div>
                <div class="col-2 col-md-3 col-lg-5 col-right">
                    <Navbar :isShowNav="isShowNav" @toggle-navbar="toggleNavbar"/>
                    <div class="d-flex justify-content-end gap-2">
                        <span class="btn-toggle toggle-search text-white d-sm-none" @click="toggleSearch">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19.343C15.4183 19.343 19 15.7613 19 11.343C19 6.92474 15.4183 3.34302 11 3.34302C6.58172 3.34302 3 6.92474 3 11.343C3 15.7613 6.58172 19.343 11 19.343Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 21.343L16.65 16.993" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="btn-toggle toggle-nav text-white d-lg-none" v-if="!isShowNav" @click="toggleNavbar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </span>
                        <span class="btn-toggle toggle-nav text-white d-lg-none" v-if="isShowNav" @click="toggleNavbar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import Logo from './header/Logo.vue'
import Search from './header/Search.vue'
import Navbar from './header/Navbar.vue'
import { ref, onMounted, onBeforeUnmount } from 'vue';
   
    const isShowNav = ref(false);
    const isShowSearch = ref(false);
    const isBgDark = ref(false);
    const props = defineProps({
        headerClass: {
            type: String,
            default: ''
        },
        isHeaderAuth: {
            type: Boolean,
            default: false
        }
    })
    
    const toggleNavbar = () => {
        isShowNav.value = !isShowNav.value;
    };

    const toggleSearch = () => {
        isShowSearch.value = !isShowSearch.value;
    };

    const handleScroll = () => {
        isBgDark.value = window.scrollY >= 100 && props.headerClass != "";
    };
    onMounted(() => {
        window.addEventListener('scroll', handleScroll);
    });

    onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll);
    });
</script>

<style lang="scss">
.page-header{
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 99;
    background: url('../../assets/images/header_bg.png') no-repeat center center / cover;

    &.bg-theme-transparent{
        background: transparent;
    }

    &.bg-theme-dark{
        background: #000000;
    }

    .header-wrap{
        padding: 4px 66px;
    }
}

@media (max-width: 1199px) {  
    .page-header{
        .header-wrap{
            padding-inline: 30px;
        }

        .btn-toggle{
            cursor: pointer;
        }

        .toggle-nav{
            z-index: 10;
        }
    }
}
</style>