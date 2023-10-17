<template>
    <div class="review">
        <div class="container-fluid">
            <div class="row align-items-center review-slider normal-slider">
                <div class="col-md-6" v-for="review in reviews" :key="review.id">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img :src="review.photo" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>{{ review.image }}</h2>
                            <h3>Profession</h3>
                            <div class="ratting">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onBeforeMount, onUpdated } from "vue";
import { basicStore } from "../../store/basic";
import axios from "axios";
const basic = basicStore;
const reviews = ref({})
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=review`)
        .then(res => {
            //console.log(res.data)
            reviews.value = res.data.data
        });
})

onUpdated(() => {
    $(function () {
        // Review slider
        $('.review-slider').slick({
            autoplay: true,
            dots: false,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

    });
});
</script>

<style scoped>

</style>
