<template>
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>New Hot Products</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/713RjwxmgfL._SL1500_.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/jia-pota-compressor.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/whitepepper-compressor.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/Shatavari-compressor.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/jia-pota-compressor.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="product-detail.html">
                                <img src="img/Nirgundi-seeds-compressor.jpg" alt="Product Image">
                            </a>

                        </div>
                        <div class="product-title-here">
                            <h3>Chia Seeds for Weight Loss, Omega-3</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>99</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue";

onMounted(() => {
    $(function () {
        // Product Slider 4 Column
        $('.product-slider-4').slick({
            autoplay: true,
            infinite: true,
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                },
            ]
        });
    })

});
</script>

<style scoped>

</style>
