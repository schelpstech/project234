<body class="g-sidenav-show   bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand d-flex align-items-center m-0" href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>" target="_blank">
                <img class="navbar-brand-img" src="../../assets/img/logo-ct.png" alt="">
                <span class="font-weight-bold ms-2">CRSM</span>
            </a>
        </div>
        <div class="collapse navbar-collapse px-3  w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>" class="nav-link text-white active opacity-10" aria-controls="dashboardsExamples" role="button" aria-expanded="true">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 4C3 3.44772 3.44772 3 4 3H16C16.5523 3 17 3.44772 17 4V6C17 6.55228 16.5523 7 16 7H4C3.44772 7 3 6.55228 3 6V4Z" class="color-background" />
                                <path d="M3 10C3 9.44771 3.44772 9 4 9H10C10.5523 9 11 9.44771 11 10V16C11 16.5523 10.5523 17 10 17H4C3.44772 17 3 16.5523 3 16V10Z" class="color-background" />
                                <path d="M14 9C13.4477 9 13 9.44771 13 10V16C13 16.5523 13.4477 17 14 17H16C16.5523 17 17 16.5523 17 16V10C17 9.44771 16.5523 9 16 9H14Z" class="color-background" />
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2"> School Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples1" class="nav-link text-white opacity-9" aria-controls="pagesExamples1" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>spaceship</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(4.000000, 301.000000)">
                                                <path class="color-background" d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z">
                                                </path>
                                                <path class="color-background" d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z">
                                                </path>
                                                <path class="color-background" d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" opacity="0.598539807"></path>
                                                <path class="color-background" d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" opacity="0.598539807"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Profile</span>
                    </a>
                    <div class="collapse " id="pagesExamples1">
                        <ul class="nav border-start ms-4">
                            
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('corporate_form') ?>">
                                    <span class="sidenav-mini-icon"> Cpt </span>
                                    <span class="sidenav-normal"> Corporate </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 "  href="../../app/router.php?pageid=<?php echo base64_encode('contact_form') ?>">
                                    <span class="sidenav-mini-icon"> Cnt </span>
                                    <span class="sidenav-normal"> Contact </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 "  href="../../app/router.php?pageid=<?php echo base64_encode('availableClasses') ?>">
                                    <span class="sidenav-mini-icon"> Cls </span>
                                    <span class="sidenav-normal"> Classes </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('approval_record') ?>">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal"> Approvals </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('facility_record') ?>">
                                    <span class="sidenav-mini-icon"> F </span>
                                    <span class="sidenav-normal"> Facilities </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples2" class="nav-link text-white opacity-9" aria-controls="pagesExamples2" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>customer-support</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(1.000000, 0.000000)">
                                                <path class="color-background" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z" opacity="0.59858631"></path>
                                                <path class="color-foreground" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z">
                                                </path>
                                                <path class="color-foreground" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Personnel</span>
                    </a>
                    <div class="collapse " id="pagesExamples2">
                        <ul class="nav border-start ms-4">
                            
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('add_personnel') ?>">
                                    <span class="sidenav-mini-icon"> Cpt </span>
                                    <span class="sidenav-normal"> Manage Personnel </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('post_vacancy') ?>">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal"> Job Vacancy </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples3" class="nav-link text-white opacity-9" aria-controls="pagesExamples3" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>credit-card</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(453.000000, 454.000000)">
                                                <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Finance</span>
                    </a>
                    <div class="collapse " id="pagesExamples3">
                        <ul class="nav border-start ms-4">
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('enrolment') ?>">
                                    <span class="sidenav-mini-icon"> Bil </span>
                                    <span class="sidenav-normal"> Billing </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('billGenerator') ?>">
                                    <span class="sidenav-mini-icon"> Inv </span>
                                    <span class="sidenav-normal"> Invoices </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('transaction') ?>">
                                    <span class="sidenav-mini-icon"> Trs </span>
                                    <span class="sidenav-normal"> Transactions </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples4" class="nav-link text-white opacity-9" aria-controls="pagesExamples4" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>document</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(154.000000, 300.000000)">
                                                <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                                <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Report</span>
                    </a>
                    <div class="collapse " id="pagesExamples4">
                        <ul class="nav border-start ms-4">
                            
                           
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="#">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal"> View </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples5" class="nav-link text-white opacity-9" aria-controls="pagesExamples5" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>basket</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1869.000000, -741.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g id="basket" transform="translate(153.000000, 450.000000)">
                                                <path class="color-background" d="M34.080375,13.125 L27.3748125,1.9490625 C27.1377583,1.53795093 26.6972449,1.28682264 26.222716,1.29218729 C25.748187,1.29772591 25.3135593,1.55890827 25.0860125,1.97535742 C24.8584658,2.39180657 24.8734447,2.89865282 25.1251875,3.3009375 L31.019625,13.125 L10.980375,13.125 L16.8748125,3.3009375 C17.1265553,2.89865282 17.1415342,2.39180657 16.9139875,1.97535742 C16.6864407,1.55890827 16.251813,1.29772591 15.777284,1.29218729 C15.3027551,1.28682264 14.8622417,1.53795093 14.6251875,1.9490625 L7.919625,13.125 L0,13.125 L0,18.375 L42,18.375 L42,13.125 L34.080375,13.125 Z" opacity="0.595377604"></path>
                                                <path class="color-background" d="M3.9375,21 L3.9375,38.0625 C3.9375,40.9619949 6.28800506,43.3125 9.1875,43.3125 L32.8125,43.3125 C35.7119949,43.3125 38.0625,40.9619949 38.0625,38.0625 L38.0625,21 L3.9375,21 Z M14.4375,36.75 L11.8125,36.75 L11.8125,26.25 L14.4375,26.25 L14.4375,36.75 Z M22.3125,36.75 L19.6875,36.75 L19.6875,26.25 L22.3125,26.25 L22.3125,36.75 Z M30.1875,36.75 L27.5625,36.75 L27.5625,26.25 L30.1875,26.25 L30.1875,36.75 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Support</span>
                    </a>
                    <div class="collapse " id="pagesExamples5">
                        <ul class="nav border-start ms-4">
                            
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('newTicket') ?>">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal"> New Ticket </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('ticketLog') ?>">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal"> My Ticket </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#authExamples6" class="nav-link text-white opacity-9" aria-controls="authExamples6" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                            <svg width="16px" height="16px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>settings</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(304.000000, 151.000000)">
                                                <polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                                <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                                <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-2">Authentication</span>
                    </a>
                    <div class="collapse " id="authExamples6">
                        <ul class="nav border-start ms-4">
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('activity_log') ?>">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal">Activity Log </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('accesscode') ?>">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal"> Reset Password </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white opacity-9 " href="../../app/router.php?pageid=<?php echo base64_encode('userProfile') ?>">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal"> Manage User </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
            </ul>
        </div>
        <div class="sidenav-footer mx-4 my-3 pt-3">
            <div class="card border-0 border-radius-md" id="sidenavCard">
                <div class="card-body  text-start  p-3 w-100">
                    <div class="mb-3">
                        <i class="fas fa-file text-primary" id="sidenavCardIcon"></i>
                    </div>
                    <div class="docs-info">
                        <h6 class="font-weight-bold up mb-2">Need help?</h6>
                        <a href="../../app/router.php?pageid=<?php echo base64_encode('newTicket') ?>" target="_blank" class="font-weight-bold text-sm mb-0 icon-move-right mt-auto w-100 mb-0">
                            Contact Support
                            <i class="fas fa-arrow-right-long text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </aside>