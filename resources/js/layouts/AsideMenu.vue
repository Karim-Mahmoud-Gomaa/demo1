<template>
    <div class="vertical-menu">
        <!-- LOGO -->
        <!--
            
        -->
        <div class="titlebar-brand-box">
            <router-link :to="{name:'home'}" tag="a" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="https://fakeimg.pl/60x60/" alt="" style="height: 35px;">
                </span>
                <span class="logo-lg ms-3">
                    <img src="/assets/images/default.png" alt="" style="height:62px;">
                </span>
            </router-link>
            <router-link :to="{name:'home'}" tag="a" class="logo logo-light">
                <span class="logo-sm">
                    <img src="https://fakeimg.pl/60x60/" alt="" style="height: 35px;">
                </span>
                <span class="logo-lg ms-3">
                    <img src="/assets/images/default.png" alt="" style="height:62px;">
                </span>
            </router-link>
        </div>
        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>
        <div data-simplebar class="sidebar-menu-scroll mt-0">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title"> Menu</li>
                    <li class="mm-active">
                        <router-link :to="{name:'home'}" tag="a" class="link-page">
                            <i class="uil-home-alt"></i>
                            <span>Home Page</span>
                        </router-link>
                    </li>
                   

                    <!--Start Admin Views-->
                   
                    <li>
                        <router-link :to="{name:'campaigns'}" tag="a" class="link-page">
                            <i class="fa-solid fa-rectangle-ad"></i><span>Campaigns</span>
                        </router-link>
                    </li>
                    
                    <!--end Admin Views-->

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        let externalScript = document.createElement('script')
        externalScript.setAttribute('src', '/assets/js/app.js')
        document.head.appendChild(externalScript)
    },
}
</script>