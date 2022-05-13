<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}
?>

.header-top-item i, .product-item .meta-list li a i,.client-item blockquote::before, .section__header-center .cate, .counter__item .counter__icon, .counter__item .subtitle, .footer-wrapper .footer__widget ul li a:hover, .privacy--menu li a:hover, .hero-content .breadcrumb li, .filter-widget .title i, .meta__date .meta__item i, .post__item .post__read, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .widget__post .widget__post__content span, .contact__info-item ul li i, .more--btn:hover, .banner-content .subtitle,.dashboard__item .thumb, p a, .dashboard-menu ul li a i, .select2-container--default .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: <?php echo $color ?>;
}

.preloader .wellcome span,
.specification__lists li .name,
.text--base {
    color: <?php echo $color ?> !important;
}
.how__item .how__icon::after, .how__item .how__icon::before, .product-item .product-thumb .ticker,
.owl-dots .owl-dot, .cmn--btn, .section__header .title, .product-item .meta-list li .buy-now, .social-icons li a:hover, .filter-widget .sub-title::after, .filter-widget .ui-slider-range, .widget__title::after, .cmn--table thead tr th {
    background: <?php echo $color ?>;
}

.cmn--btn, .form--check .form-check-input:checked {
    border : <?php echo $color ?>33;
}

.section__header {
    border-bottom: 1px solid <?php echo $color ?>;
}
.product-item, .dashboard__item,
.counter__item, .post__item {
    box-shadow: 0 0 0.075rem rgb(255 255 255 / 60%), 0 0 0.075rem rgb(255 255 255 / 60%), 0 0 5px <?php echo $color ?>4d, 0 0 8px <?php echo $color ?>4d, 0 0 10px <?php echo $color ?>4d;
}
.countdown__title {
    border: 1px dashed <?php echo $color ?>b3;
}

.pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a,
.filter-widget .ui-state-default, .form--check .form-check-input:checked {
    background-color: <?php echo $color ?>;
    
}
.pagination .page-item.disabled span {
    background-color: <?php echo $color ?>4d;
}
.meta__date {
    border-left: 5px solid <?php echo $color ?>;
}
.recent__logins .item .thumb,
.widget {
    border: 1px dashed <?php echo $color ?>4d;
}

.btn--base, .badge--base, .bg--base {
    background: <?php echo $color ?> !important;
}
.sidebar__init,
::selection,
.about-seller::after,
.scrollToTop,
button.cmn--btn:hover {
    background: <?php echo $color ?>;
}

.cart-plus-minus .cart-decrease:hover, .cart-plus-minus .cart-decrease.active, .cart-plus-minus .cart-increase:hover, .cart-plus-minus .cart-increase.active {
    background: <?php echo $color ?>;
    border-color: <?php echo $color ?>;
    color: #fff;
}


.nav--tabs li a.active {
    border-color: <?php echo $color ?>;
    color: <?php echo $color ?>;
}
.dashboard-menu ul li a:hover, .dashboard-menu ul li a.active {
    border-color: <?php echo $color ?>
}

.countdown-area, .seller-area {
    border-bottom: 1px solid <?php echo $color ?>66;
}