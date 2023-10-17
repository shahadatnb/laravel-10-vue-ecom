<template>
    <!-- Checkout Start -->
    <div class="checkout">
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-inner">
                            <div class="billing-address">
                              
                                <p>অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span>Submit Your Order</span>  বাটনে ক্লিক করুন </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Enter Your Full Name</label>
                                        <input class="form-control" type="text" placeholder=" সম্পূর্ন নামটি লিখুন ">
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <label>Enter Mobile No</label>
                                        <input class="form-control" type="text" placeholder=" ১১ ডিজিটের মোবাইল নাম্বার লিখুন ">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Enter Full Address</label>
                                        <input class="form-control" type="text" placeholder=" সম্পূর্ন ঠিকানা লিখুন ">
                                    </div>

                                
                                  
                                    
                                    <div class="col-md-12">
                                        <label>Choose Delivery Area </label>
                                        <select class="custom-select">
                                            <option selected> ঢাকার ভিতরে </option>
                                            <option> ঢাকার বাহিরে </option>
                                            
                                        </select>
                                    </div>
                                  
                                    <div class="col-md-12 text-center">
                                        <div class="checkout-btn">
                                            <button> Submit Your Order </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                       
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-inner">
                            <div class="checkout-summary">
                                <h1>Cart Total</h1>
                                <p>Product Name<span>$99</span></p>
                                <p class="sub-total">Sub Total<span>$99</span></p>
                                <p class="ship-cost">Shipping Cost<span>$1</span></p>
                                <h2>Grand Total<span>$100</span></h2>
                            </div>

              
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->
</template>