<template>
    <MainLayout>
        <Search :title="'List Review'" @search="handleSearch" />
        <div>
            <table class="table table-hover mt-3">
                <thead class="">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User</th>
                        <th scope="col">Course</th>
                        <th scope="col">Content</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="review in reviews" :key="review.id">
                        <td>{{ review.id }}</td>
                        <td>{{ review.user_name }}</td>
                        <td>{{ review.course_title }}</td>
                        <td style="max-width: 300px;">
                            <Seemore :text="review.content" :maxLength="100"/>
                        </td>
                        <td>{{ review.rating }}</td>
                        <td>
                            <button 
                                class="btn btn-primary text mx-3" 
                                :class="{'disabled': review.is_published == 1}" 
                                @click="updateStatusReview(review.id ,1)"
                            >
                                {{review.is_published == 1 ? 'Accepted' : 'Accept' }}
                            </button>
                            <button 
                                class="btn btn-danger text mx-3" 
                                :class="{'disabled': review.is_published == 0}"
                                @click="updateStatusReview(review.id, 0)"
                            >
                                {{review.is_published == 0 ? 'Rejected' : 'Reject' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination 
                :pagination="pagination"
                :to="'reviews'"
            />
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '@/layout/MainLayout.vue';
    import Pagination from '@/components/Pagination.vue';
    import Seemore from '@/components/Seemore.vue';
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from 'axios';

    const reviews = ref([]);
    const pagination = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        fetchReviews();
    });

    watch(route, () => {
        fetchReviews();
    });

    /**
     * Get List Review
     */
    const fetchReviews = async () => {
        try {
            const page= route.query.page;
            const search = route.query.search;
            const response = await axios.get(`admin/review?page=${page ?? ''}&search=${search ?? ''}`);
            
            if (response.data) {
                reviews.value = response.data.data;
                pagination.value = response.data.meta;
            }
        } catch (err) {
            throw new Error(err);
        }
    };

    /**
     * Update Status Review
     */
    const updateStatusReview = async (id, status) => {
        try {
            const response = await axios.put('admin/review/update', {id: id, is_published: status});
            
            if (!response.data.error) {
                window.location.reload();
            }
        } catch (err) {
            throw new Error(err);
        }
    };

    /**
     * Search Review
     */
    const handleSearch = (searchValue) => {
        if (searchValue != "") {
            router.push(`reviews?search=${searchValue}`);
        } else {
            router.push(`reviews`);
        }
    };
</script>