import { createRouter, createWebHistory } from 'vue-router'
import { verifyToken } from '@/utils/verify_token';
import { getCookie } from '@/utils/cookie'

const routes = [
	{
		path: '/admin/login',
		name: 'login',
		component: () => import('../views/Login.vue'),
		meta: { checkAuthenticated: true }
	},
	{
		path: '/',
		children: [
			{
				path: '/',
				name: 'dashboard',
				component: () => import('../views/Dashboard.vue'),
			},
			{
				path: '/trainers',
				name: 'trainers',
				component: () => import('../views/User/Trainer.vue'),
			},
			{
				path: '/students',
				name: 'students',
				component: () => import('../views/User/Student.vue'),
			},
			{
				path: '/trainers/:id',
				name: 'user-trainer',
				component: () => import('../views/User/TrainerDetail.vue'),
				props: true
			},
			{
				path: '/trainers/course/:id',
				name: 'user-trainer-course',
				component: () => import('../views/User/ListStudent.vue'),
				props: true
			},
			{
				path: '/students/:id',
				name: 'user-student',
				component: () => import('../views/User/StudentDetail.vue'),
				props: true
			},
			{
				path: '/courses',
				name: 'course_list',
				component: () => import('../views/Course/List.vue'),
			},
			{
				path: '/courses/:id',
				name: 'course_detail',
				component: () => import('../views/Course/Detail.vue'),
				props: true
			},
			{
				path: '/reviews',
				name: 'reviews',
				component: () => import('../views/Reviews.vue'),
			},
		],
		meta: {requireAuth: true},
	},
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
});
router.beforeEach((to, from, next) => {
	const checkAuthenticated = to.matched.some(record => record.meta.checkAuthenticated);
	const requireAuth = to.matched.some(record => record.meta.requireAuth);
	const adminToken = getCookie('adminToken');
	if (checkAuthenticated) {
		if (adminToken) {
			const isVerifyToken = verifyToken(adminToken);

			if (!isVerifyToken.error) {
				next({ name: 'dashboard' });
			} else {
				next();
			}
		} else {
			next();
		}
	}

	if (requireAuth) {
		if (adminToken) {
			next();
		} else {
			next({ name: 'login' });
		}
	}
	next();
});
export default router
