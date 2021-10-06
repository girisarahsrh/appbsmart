@include('_uiAssets.Header')
<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(/Assets/assets/images/landingpage/banner-bg.png) 
            no-repeat center center;
            height: 100%; 
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;">
            <div class="auth-box row">
                {{-- <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(/Assets/assets/images/BPKP_Logo_2.png);">
                </div> --}}
                <div class="col-lg-12 col-md-7 bg-white" style="border-radius: 15px;">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="/Assets/assets/images/BPKP_Logo_2.png" alt="wrapkit">
                        </div>
                        {{-- <h2 class="mt-3 text-center">Log In</h2> --}}
                        <p class="text-center" style="padding-top: 5%">B'SMART 2021 Online</p>
                        <form action="/Auth" method="POST" class="mt-4">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Username</label>
                                        <input class="form-control"  name="username" id="username" type="text"
                                            placeholder="username">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="passw">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="*****"
                                                aria-label="Input group example" aria-describedby="btnGroupAddon">

                                            <div class="input-group-prepend">
                                                <a href="javascript:;" onclick="showPassword()"><div class="input-group-text" id="btnGroupAddon"><i
                                                        class="fa fas fa-eye"></i>
                                                </a></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                                

                                
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>

    @include('_uiAssets.Footer')
    @include('Login.Script')
   