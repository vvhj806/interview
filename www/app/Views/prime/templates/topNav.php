<?php if (0) : ?>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= $data['url']['www'] ?>/prime/main" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout" role="button"><b>logout</b></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
<?php endif; ?>
<!--s #headBoxx-->
<div id="headBox">
    <!--s #head-->
    <div id="head">
        <!--s admin_logo-->
        <div class="admin_logo">
            <button class='nav_con'><i class="fas fa-bars"></i></button>
            <a href="/prime/main"><img src="/static/prime/img/admin_logo.png"></a>
        </div>
        <!--e admin_logo-->

        <!--s right_group-->
        <div class="right_group">
            <div class="user_name"><i class="la la-user"></i> ???????????????! <span class="point"><?= $data['session']['name'] ?></span>???</div>
            <!--s btnBox-->
            <div class="btnBox">
                <a href="/prime/main"><i class="la la-home"></i> ????????? ????????????</a>
                <a href="/logout" class="logout"><i class="la la-sign-out"></i> ????????????</a>
            </div>
            <!--e btnBox-->
        </div>
        <!--e right_group-->
    </div>
    <!--e #head-->
</div>
<!--e #headBox-->