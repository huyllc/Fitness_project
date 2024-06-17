<template>
    <footer class="page-footer">
        <div class="app-container">
            <div class="footer-wrap">
                <div class="row align-items-center justify-content-between row-top">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <strong>Subscribe on our newsletter</strong>
                            <p>Get daily news on upcoming offers from many suppliers all over the world</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-4">
                        <form action="" class="form-group d-flex gap-1 justify-content-end form-subscribe">
                            <input type="text" class="input-subscribe border-0 py-0 px-2 w-100"> 
                            <button class="btn-subscribe btn-danger border-0">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-between row-middle">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <h2 class="text-uppercase">
                            Ready for  <br/>
                            <strong>awesome</strong> Life?  
                        </h2>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-4">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-8 col-xl-6 ">
                                <router-link to="/" class="review-link bg-white fw-semibold d-inline-block">
                                    Review Website?
                                </router-link>
                            </div>
                            <div class="col-4 col-xl-6">
                                <div class="footer-social d-flex gap-3 justify-content-end">
                                    <a href="">
                                        <img src="@/assets/images/facebook-icon.svg" alt="">
                                    </a>
                                    <a href="">
                                        <img src="@/assets/images/insta-icon.svg" alt="">
                                    </a>
                                    <a href="">
                                        <img src="@/assets/images/linkin-icon.svg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between row-bottom">
                    <div class="col-12 col-sm-6 mb-3 mb-md-0">
                        <span class="icon-email pe-3">
                            <svg width="25" height="19" viewBox="0 0 25 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5 14.1875C11.6929 14.1875 10.8857 13.9228 10.1973 13.3862L0 5.45703V16.5312C0 17.8252 1.04932 18.875 2.34375 18.875H22.6562C23.9507 18.875 25 17.8257 25 16.5312V5.45703L14.8047 13.3916C14.1162 13.9238 13.3057 14.1875 12.5 14.1875ZM0.79541 4.09473L11.1567 12.1562C11.9473 12.7715 13.0547 12.7715 13.8452 12.1562L24.2065 4.09473C24.6631 3.7041 25 3.10352 25 2.46875C25 1.17432 23.9502 0.125 22.6562 0.125H2.34375C1.04932 0.125 0 1.17432 0 2.46875C0 3.10352 0.293457 3.7041 0.79541 4.09473Z" fill="white"/>
                                </svg>
                        </span>
                        <span>Info@devfastfitness.com</span>
                    </div>
                    <div class="col-12 col-sm-6 text-sm-end">
                        <span class="pe-4">Terms  & Conditions</span>
                        <span class="">Privacy Policy</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style lang="scss">
.page-footer{
    background: #171717;
    color: #FFFFFF;
    margin-top: 60px;
    
    .app-container{
        padding: 32px 20px;
    }

    h2{
        font-size: 50px;

        strong{
            color: #D43B3B;
        }
    }

    .footer-wrap{
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .input-subscribe{
        outline: none;
        height: 40px;
        border-radius: 5px;
    }
    
    .btn-subscribe{
        border-radius: 5px;
        padding-inline: 16px;
    }

    .review-link{
        color: #D43B3B;
        text-decoration: none;
        font-weight: 600;
        padding: 5px 16px;
        border-radius: 5px;
    }

    .row-top{
        margin-bottom: 32px;
    }
}

@media (max-width: 1024px) {
    .page-footer{
        h2 {
            font-size: 35px;
        }
    }
}

@media (max-width: 767px) {
    .page-footer{
        font-size: 14px;

        h2 {
            font-size: 25px;
        }

        .row-middle{
            margin-bottom: 30px;
        }
    }
}
</style>