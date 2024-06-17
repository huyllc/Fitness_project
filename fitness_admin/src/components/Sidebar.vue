<template>
    <div class="block-sidebar min-vh-100 position-fixed h-100">
        <router-link to="/" class="d-block">
            <img src="@/assets/images/dashboard_logo.svg" class="img-fluid" alt="">
        </router-link>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <router-link to="/" class="nav-link px-4 py-3 active-link" exact-active-class="active">
                    <span class="pe-3">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 23.5337H15C20 23.5337 22 21.3956 22 16.0503V9.63605C22 4.29081 20 2.15271 15 2.15271H9C4 2.15271 2 4.29081 2 9.63605V16.0503C2 21.3956 4 23.5337 9 23.5337Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.2802 14.5644C15.1502 15.7724 13.5302 16.1466 12.1002 15.6655L9.5102 18.4237C9.3302 18.6268 8.9602 18.7551 8.6902 18.7123L7.4902 18.5412C7.0902 18.4878 6.7302 18.0816 6.6702 17.6646L6.5102 16.3818C6.4702 16.1038 6.6002 15.7083 6.7802 15.5051L9.3602 12.747C8.9202 11.2183 9.2602 9.48641 10.3902 8.27839C12.0102 6.54653 14.6502 6.54653 16.2802 8.27839C17.9002 9.99956 17.9002 12.8218 16.2802 14.5644Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.4501 17.4188L9.6001 16.4994" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.3945 11.4535H13.4035" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Dashboard
                </router-link>
            </li>
            <li class="nav-item">
                <router-link
                    to="/trainers" 
                    class="nav-link px-4 py-3 active-link" 
                    exact-active-class="active"
                    :class="{ 'active': isRouteActive('/trainers') }"
                >
                    <span class="pe-3">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.0006 24.6496H9.00063C7.68063 24.6496 6.58063 24.5106 5.65063 24.2113C5.31063 24.1044 5.09063 23.7516 5.11063 23.3774C5.36063 20.181 8.39063 17.6686 12.0006 17.6686C15.6106 17.6686 18.6306 20.1703 18.8906 23.3774C18.9206 23.7623 18.7006 24.1044 18.3506 24.2113C17.4206 24.5106 16.3206 24.6496 15.0006 24.6496ZM6.72063 22.8429C7.38063 22.9819 8.13063 23.046 9.00063 23.046H15.0006C15.8706 23.046 16.6206 22.9819 17.2806 22.8429C16.7506 20.7903 14.5606 19.2722 12.0006 19.2722C9.44063 19.2722 7.25063 20.7903 6.72063 22.8429Z" fill="currentColor"/>
                            <path d="M15 2.46704H9C4 2.46704 2 4.60514 2 9.95038V16.3647C2 20.4057 3.14 22.6186 5.86 23.4418C6.08 20.6623 8.75 18.4707 12 18.4707C15.25 18.4707 17.92 20.6623 18.14 23.4418C20.86 22.6186 22 20.4057 22 16.3647V9.95038C22 4.60514 20 2.46704 15 2.46704ZM12 15.4774C10.02 15.4774 8.42 13.7562 8.42 11.6395C8.42 9.52279 10.02 7.81229 12 7.81229C13.98 7.81229 15.58 9.52279 15.58 11.6395C15.58 13.7562 13.98 15.4774 12 15.4774Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9999 16.2792C9.60992 16.2792 7.66992 14.1945 7.66992 11.6395C7.66992 9.08447 9.60992 7.0105 11.9999 7.0105C14.3899 7.0105 16.3299 9.08447 16.3299 11.6395C16.3299 14.1945 14.3899 16.2792 11.9999 16.2792ZM11.9999 8.61407C10.4399 8.61407 9.16992 9.97179 9.16992 11.6395C9.16992 13.3179 10.4399 14.6756 11.9999 14.6756C13.5599 14.6756 14.8299 13.3179 14.8299 11.6395C14.8299 9.97179 13.5599 8.61407 11.9999 8.61407Z" fill="currentColor"/>
                        </svg>
                    </span>
                    Trainers
                </router-link>
            </li>
            <li class="nav-item">
                <router-link 
                    to="/students" 
                    class="nav-link px-4 py-3 active-link" 
                    exact-active-class="active"
                    :class="{ 'active': isRouteActive('/students') }"
                >
                    <span class="pe-3">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.0006 24.6496H9.00063C7.68063 24.6496 6.58063 24.5106 5.65063 24.2113C5.31063 24.1044 5.09063 23.7516 5.11063 23.3774C5.36063 20.181 8.39063 17.6686 12.0006 17.6686C15.6106 17.6686 18.6306 20.1703 18.8906 23.3774C18.9206 23.7623 18.7006 24.1044 18.3506 24.2113C17.4206 24.5106 16.3206 24.6496 15.0006 24.6496ZM6.72063 22.8429C7.38063 22.9819 8.13063 23.046 9.00063 23.046H15.0006C15.8706 23.046 16.6206 22.9819 17.2806 22.8429C16.7506 20.7903 14.5606 19.2722 12.0006 19.2722C9.44063 19.2722 7.25063 20.7903 6.72063 22.8429Z" fill="currentColor"/>
                            <path d="M15 2.46704H9C4 2.46704 2 4.60514 2 9.95038V16.3647C2 20.4057 3.14 22.6186 5.86 23.4418C6.08 20.6623 8.75 18.4707 12 18.4707C15.25 18.4707 17.92 20.6623 18.14 23.4418C20.86 22.6186 22 20.4057 22 16.3647V9.95038C22 4.60514 20 2.46704 15 2.46704ZM12 15.4774C10.02 15.4774 8.42 13.7562 8.42 11.6395C8.42 9.52279 10.02 7.81229 12 7.81229C13.98 7.81229 15.58 9.52279 15.58 11.6395C15.58 13.7562 13.98 15.4774 12 15.4774Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9999 16.2792C9.60992 16.2792 7.66992 14.1945 7.66992 11.6395C7.66992 9.08447 9.60992 7.0105 11.9999 7.0105C14.3899 7.0105 16.3299 9.08447 16.3299 11.6395C16.3299 14.1945 14.3899 16.2792 11.9999 16.2792ZM11.9999 8.61407C10.4399 8.61407 9.16992 9.97179 9.16992 11.6395C9.16992 13.3179 10.4399 14.6756 11.9999 14.6756C13.5599 14.6756 14.8299 13.3179 14.8299 11.6395C14.8299 9.97179 13.5599 8.61407 11.9999 8.61407Z" fill="currentColor"/>
                        </svg>
                    </span>
                    Students
                </router-link>
            </li>
            <li class="nav-item">
                <router-link 
                    to="/courses" class="nav-link px-4 py-3 active-link" 
                    exact-active-class="active"
                    :class="{ 'active': isRouteActive('/courses') }"
                >
                    <span class="pe-3">
                        <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7516 19.0107V21.1809C10.7516 23.0197 9.15158 24.5057 7.18158 24.5057C5.21158 24.5057 3.60156 23.0197 3.60156 21.1809V19.0107C3.60156 20.8495 5.20158 22.1537 7.18158 22.1537C9.15158 22.1537 10.7516 20.8388 10.7516 19.0107Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.7503 16.0705C10.7503 16.605 10.6103 17.0968 10.3703 17.5244C9.7803 18.5614 8.57028 19.2135 7.17028 19.2135C5.77028 19.2135 4.56027 18.5507 3.97027 17.5244C3.73027 17.0968 3.59033 16.605 3.59033 16.0705C3.59033 15.1511 3.99031 14.328 4.63031 13.7293C5.28031 13.1199 6.17027 12.7565 7.16027 12.7565C8.15027 12.7565 9.0403 13.1306 9.6903 13.7293C10.3503 14.3173 10.7503 15.1511 10.7503 16.0705Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.7516 16.0705V19.0104C10.7516 20.8491 9.15158 22.1534 7.18158 22.1534C5.21158 22.1534 3.60156 20.8384 3.60156 19.0104V16.0705C3.60156 14.2317 5.20158 12.7457 7.18158 12.7457C8.17158 12.7457 9.06161 13.1199 9.71161 13.7186C10.3516 14.3172 10.7516 15.1511 10.7516 16.0705Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.0002 12.7135V14.9159C22.0002 15.5039 21.5602 15.9848 21.0002 16.0062H19.0401C17.9601 16.0062 16.9702 15.1617 16.8802 14.0071C16.8202 13.3336 17.0601 12.7029 17.4801 12.2645C17.8501 11.8583 18.3602 11.6232 18.9202 11.6232H21.0002C21.5602 11.6445 22.0002 12.1256 22.0002 12.7135Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12.2112V10.0732C2 7.16534 3.64 5.13414 6.19 4.79205C6.45 4.74929 6.72 4.72791 7 4.72791H16C16.26 4.72791 16.51 4.73859 16.75 4.78135C19.33 5.10206 21 7.14396 21 10.0732V11.6233H18.92C18.36 11.6233 17.85 11.8585 17.48 12.2647C17.06 12.703 16.82 13.3338 16.88 14.0073C16.97 15.1618 17.96 16.0064 19.04 16.0064H21V17.5565C21 20.7636 19 22.9017 16 22.9017H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Courses
                </router-link>
            </li>
            <li class="nav-item">
                <router-link 
                    to="/reviews" class="nav-link px-4 py-3 active-link" 
                    exact-active-class="active"
                    :class="{ 'active': isRouteActive('/reviews') }"
                >
                    <span class="pe-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5"/>
                            <path d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194z"/>
                        </svg>
                    </span>
                    Reviews
                </router-link>
            </li>

        </ul>
    </div>
</template>

<script setup>
    import { removeCookie } from '@/utils/cookie';
    import router from '@/router';
    import { computed } from 'vue';

    const isRouteActive = computed(() => (route) => {
        return router.currentRoute.value.path.startsWith(route) || router.currentRoute.value.path.match(new RegExp('^' + route + '(\/\\d+)?$'));
    });
</script>


<style lang="scss">
.block-sidebar{
    padding: 20px 30px;
    box-shadow: 0 10px 10px rgba(0,0,0,0.15);
    width: 16.66667%;
}

.nav.nav-pills{
    padding-block: 35px;

    .nav-link{
        color: #9197B3;

        &.active{
            color: #FFF;
            border-radius: 10px;
            background: #5932EA;
        }
    }
}

.nav-item{
    margin: 0 -24px;
}
</style>