<?php if (0) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Online Store Visitors</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">820</span>
                                <span>Visitors Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12.5%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> This Week
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Last Week
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Products</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Sales</th>
                                    <th>More</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        Some Product
                                    </td>
                                    <td>$13 USD</td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            12%
                                        </small>
                                        12,000 Sold
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        Another Product
                                    </td>
                                    <td>$29 USD</td>
                                    <td>
                                        <small class="text-warning mr-1">
                                            <i class="fas fa-arrow-down"></i>
                                            0.5%
                                        </small>
                                        123,234 Sold
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        Amazing Product
                                    </td>
                                    <td>$1,230 USD</td>
                                    <td>
                                        <small class="text-danger mr-1">
                                            <i class="fas fa-arrow-down"></i>
                                            3%
                                        </small>
                                        198 Sold
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        Perfect Item
                                        <span class="badge bg-danger">NEW</span>
                                    </td>
                                    <td>$199 USD</td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            63%
                                        </small>
                                        87 Sold
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">$18,230.00</span>
                                <span>Sales Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> This year
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Last year
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Online Store Overview</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-success text-xl">
                                <i class="ion ion-ios-refresh-empty"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-up text-success"></i> 12%
                                </span>
                                <span class="text-muted">CONVERSION RATE</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-warning text-xl">
                                <i class="ion ion-ios-cart-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                                </span>
                                <span class="text-muted">SALES RATE</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <p class="text-danger text-xl">
                                <i class="ion ion-ios-people-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-down text-danger"></i> 1%
                                </span>
                                <span class="text-muted">REGISTRATION RATE</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
<?php endif; ?>
<!--s mem_totalBox-->
<?php
// echo "<pre>";
// print_r($data['leftNav']);

// exit;
?>
<div class="mem_totalBox">
    <!--s wBox01-->
    <div class="wBox wBox01 c">
        <!--s txtBox-->
        <div class="txtBox">
            <div class="num point"><?= number_format($data['m']['join']['alltime']) ?>명</div>
            <div class="txt">총 일반 회원</div>
        </div>
        <!--e txtBox-->

        <!--s txtBox-->
        <div class="txtBox">
            <div class="num point"><?= number_format($data['c']['join']['alltime']) ?>명</div>
            <div class="txt">총 비즈 회원</div>
        </div>
        <!--e txtBox-->
    </div>
    <!--e wBox01-->

    <!--s wBox_two-->
    <div class="wBox_two">
        <!--s wBox-->
        <div class="wBox c">
            <div class="stlt font16"><i class="la la-user font25"></i>일반 회원</div>

            <ul class="wUl">
                <li>
                    <div class="num point b"><?= number_format($data['m']['join']['day']) ?>명</div>
                    <div class="txt">오늘 가입 회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['m']['join']['week']) ?>명</div>
                    <div class="txt">이번 주 가입회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['m']['join']['month']) ?>명</div>
                    <div class="txt">이번 달 가입회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['m']['leave']['alltime']) ?>명</div>
                    <div class="txt">총 탈퇴 회원</div>
                </li>
            </ul>
        </div>
        <!--e wBox-->

        <!--s wBox-->
        <div class="wBox c">
            <div class="stlt font16"><i class="la la-user font25"></i> 비즈회원</div>
            <ul class="wUl">
                <li>
                    <div class="num point b"><?= number_format($data['c']['join']['day']) ?>명</div>
                    <div class="txt">오늘 가입 회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['c']['join']['week']) ?>명</div>
                    <div class="txt">이번 주 가입회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['c']['join']['month']) ?>명</div>
                    <div class="txt">이번 달 가입회원</div>
                </li>
                <li>
                    <div class="num point b"><?= number_format($data['c']['leave']['alltime']) ?>명</div>
                    <div class="txt">총 탈퇴 회원</div>
                </li>
            </ul>
        </div>
        <!--e wBox-->
    </div>
    <!--e wBox_two-->
</div>
<!--e mem_totalBox-->

<!--s mem_graphBox-->
<div class="mem_graphBox wBox wps_100 mg_t30 c">
    <!--s cont_searchBox-->
    <div class="cont_searchBox">
        <div class="form_group">
            <select id="" name="">
                <option value="">일반 회원 가입자 추이</option>
                <option value="">비즈 회원 가입자 추이</option>
            </select>
        </div>

        <div class="form_group">
            <div class="input_group_icon"><span class="la la-calendar"></span></div>
            <input type="text" id="" name="" value="" class="calendar">
        </div>

        <span class="mg_l5 mg_r5 form_txt">~</span>

        <div class="form_group">
            <div class="input_group_icon"><span class="la la-calendar"></span></div>
            <input type="text" id="" name="" value="" class="calendar">
        </div>
        <div class="form_group">
            <a href="#" class="btn btn01"><i class="la la-download font16"></i> 엑셀로 저장</a>
        </div>
    </div>
    <!--e cont_searchBox-->

    <!--s mem_graph_data-->
    <div class="mem_graph_data mg_t20">
        <!--s form_group-->
        <div class="form_group">
            <select id="" name="">
                <option value="">시간대별</option>
                <option value="">일별</option>
                <option value="">주별</option>
                <option value="">월별</option>
                <option value="">연도별</option>
            </select>
        </div>
        <!--e form_group-->

        <!--s lrBtn-->
        <div class="lrBtn c">
            <a href="#n"><i class="la la-angle-left"></i></a>
            <a href="#n"><i class="la la-angle-right"></i></a>
        </div>
        <!--e lrBtn-->
    </div>
    <!--e mem_graph_data-->

    <!--s mem_graph-->
    <div class="mem_graph">
        그래프 자리입니다.
    </div>
    <!--e mem_graph-->
</div>
<!--e mem_graphBox-->