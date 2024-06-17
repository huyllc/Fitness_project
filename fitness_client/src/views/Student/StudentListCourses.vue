<template>
	<div class="container">
		<div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="p-0">List Courses</h3>
            <Search :searchClass="searchClass" @search="emitSearchQuery" />
		</div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Course Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col"></th>
                </tr>
            </thead>
        <tbody>
            <tr v-for="(data, index) in courses" :key="index">
                <td>{{ index + 1 + (pagination.current_page -1 ) * 5  }}</td>
                <td>{{ data.course.title }}</td>
                <td style="max-width: 300px;">
                    <SeeMore :text="data.course.description" :maxLength="120"/>
                </td>
                <td>{{ data.course.duration }} {{ data.course.duration == 1 ? 'Month' : 'Months' }}</td>
                <td>
                    <img :src="data.course.thumbnail" width="60" height="60">
                </td>
                <td>
                    <RouterLink 
                        v-if="user_type == 'student'"
                        :to="{path: `/account/mycourses/${data.course.id}`}"
                        type="button" 
                        class="btn btn-to-detail me-2" 
                    >
                        Detail
                    </RouterLink>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
</template>

<script setup>
    import { ref, defineProps } from 'vue';
    import { getCookie } from '@/utils/cookie';
    import SeeMore from '@/components/SeeMore.vue';
    import Search from '@/components/Search.vue';

    const props = defineProps({
        searchClass: {
            type: String,
            default: ''
        },
        courses: {
            type: Array,
            default: () => []
        },
        pagination: {
            type: Object,
            default: () => ({})
        }
    });

    const emit = defineEmits(["search-query-changed"]);

    const user_type = ref(getCookie('user_type'));
    const query = ref("");

    const emitSearchQuery = (query) => {
        emit('search-query-changed', query);
    };
    
</script>

<style lang="scss">
.btn-to-detail{
	border: 1px solid #FF4300;
	color: #FF4300;

	&:hover{
		background: #FF4300;
		color: #FFF;
	}
}
</style>
