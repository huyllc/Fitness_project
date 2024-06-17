<template>
    <router-link class="logo-link" to="/">
        <img src="@/assets/images/logo.svg" class="logo-img" alt="devfast_fitness">
    </router-link>
</template>

<style lang="scss">
@media (max-width: 1199px) {  
    .page-header{
        .logo-img{
            max-height: 80px;
        }
    }
}

@media (max-width: 767px) {  
    .page-header{
        .logo-img{
            max-height: 60px;
        }
    }
}
</style>