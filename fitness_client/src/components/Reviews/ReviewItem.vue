<template>
    <div class="review-main bg-white row shadow-lg">
        <div class="col-2 d-flex flex-column gap-2">
            <img :src="review.user_avatar" alt="" class="review-avatar">
            <strong>{{ review.user_name }}</strong>
        </div>
        <div class="col-7">
            {{ review.content }}
        </div>
        <div class="col-3">
            <div class="rating fs-3 d-flex gap-2 flex-row-reverse">
                <span :class="{ active: review.rating === 5 }">&#9733</span>
                <span :class="{ active: review.rating === 4 }">&#9733</span>
                <span :class="{ active: review.rating === 3 }">&#9733</span>
                <span :class="{ active: review.rating === 2 }">&#9733</span>
                <span :class="{ active: review.rating === 1 }">&#9733</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        review: {}
    }
}
</script>

<style lang="scss">
.review-main{
    padding: 25px;
    border-radius: 20px;
}

.review-avatar{
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

.rating{
    span.active {
        & ~ span{
            color: orange;
            transform: scale(1.2);
        }
    }
}
</style>