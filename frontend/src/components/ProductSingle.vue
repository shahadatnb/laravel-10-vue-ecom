<template>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Product Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail-top">
                        <div class="row">
<!--                            <Gallery></Gallery>-->
                            <div class="col-md-5">
                                <div class="product-slider-single normal-slider">
                                    <img :src="product.photo" alt="Product Image">
<!--                                    <template v-for="gallery in product.galleries" :key="gallery.id + '1'">-->
                                        <img v-for="gallery in product.galleries" :key="gallery.id + '1'" :src="gallery.photo" alt="Product Image">
<!--                                    </template>-->
                                </div>
                                <div class="product-slider-single-nav normal-slider">
                                    <div class="slider-nav-img"><img :src="product.photo" alt="Product Image"></div>
<!--                                    <template v-for="gallery in product.galleries" :key="gallery.id">-->
                                        <div v-for="gallery in product.galleries" :key="gallery.id" class="slider-nav-img">
                                            <img :src="gallery.photo" alt="Product Image">
                                        </div>
<!--                                    </template>-->
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="product-content">
                                    <div class="title"><h2>{{ product.title }}</h2></div>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        (54 customer reviews)
                                    </div>
                                    <div class="price">
                                        <h4>Price:</h4>
                                        <p>${{ product.price }} <span>${{ product.reduced_price }}</span></p>
                                    </div>
                                    <div class="quantity">
                                        <h4>Quantity:</h4>
                                        <div class="qty">
                                            <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                            <input type="text" value="1">
                                            <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
<!--                                    <div class="p-size">-->
<!--                                        <h4>Weight:</h4>-->
<!--                                        <div class="btn-group btn-group-sm">-->
<!--                                            <button type="button" class="btn">500  grams</button>-->
<!--                                            <button type="button" class="btn">1000 grams</button>-->
<!--                                            <button type="button" class="btn">2000  grams</button>-->

<!--                                        </div>-->
<!--                                    </div>-->

                                    <div class="action">
                                        <a class="btn" href="#"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                        <a class="btn" href="#"><i class="fa fa-shopping-bag"></i>Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#reviews">Reviews (1)</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Product description</h4>
                                    <p>{{ product.description }}</p>
                                </div>
                                <div id="specification" class="container tab-pane fade">
                                    <h4>Product specification</h4>
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                    </ul>
                                </div>
                                <div id="reviews" class="container tab-pane fade">
                                    <div class="reviews-submitted">
                                        <div class="reviewer">Phasellus Gravida - <span>01 Jan 2020</span></div>
                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                                        </p>
                                    </div>
                                    <div class="reviews-submit">
                                        <h4>Give your Review:</h4>
                                        <div class="ratting">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <div class="row form">
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Name">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="email" placeholder="Email">
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea placeholder="Review"></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <button>Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, onBeforeMount, onMounted,onUpdated } from 'vue'
import Gallery from "./product/Gallery.vue";
import axios from 'axios'
import { useRoute } from 'vue-router';
const route = useRoute()
const slug = route.params.slug
const product = reactive({})
onBeforeMount(() => {
    axios.get(`http://127.0.0.1:8000/api/single-product/${slug}`)
        .then(res => {
            console.log(res.data)
            product.id = res.data.data.id
            product.title = res.data.data.title
            product.price = res.data.data.price
            product.reduced_price = res.data.data.reduced_price
            product.quantity = res.data.data.quantity
            product.short_description = res.data.data.short_description
            product.description = res.data.data.description
            product.photo = res.data.data.photo
            product.galleries = res.data.data.galleries
            product.categories = res.data.data.categories
        });
})

onUpdated(()=>{
    $(function () {
        // Product Detail Slider

        $('.product-slider-single').slick({
            infinite: true,
            autoplay: true,
            dots: false,
            fade: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '.product-slider-single-nav'
        })

        $('.product-slider-single-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            asNavFor: '.product-slider-single'
        });
    })


})

</script>

<style scoped>

</style>
