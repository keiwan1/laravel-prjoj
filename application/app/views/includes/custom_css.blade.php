<style type="text/css">

@include('includes.functions')

@if(isset($settings->primary_color))

	<?php $primary_color = $settings->primary_color; ?>

@else

	<?php $primary_color = '#EE222E'; ?>

@endif

@if(isset($settings->secondary_color))

	<?php $secondary_color = $settings->secondary_color; ?>

@else

	<?php $secondary_color = '#12C3EE'; ?>

@endif



<?php $lighter_color = adjustBrightness($primary_color, 20); ?>
<?php $light_color = adjustBrightness($primary_color, 50); ?>
<?php $lightest_color = adjustBrightness($primary_color, 100); ?>
<?php $dark_color = adjustBrightness($primary_color, -50); ?>

.btn.btn-color, input[type="submit"]{
	background:{{ $primary_color; }} !important;
	color:#fff;
	border-radius:0px;
}

h2 i{
	color:{{ $primary_color; }};
}

.btn-color:hover{
	color:#fff;
}

.btn.btn-radio {
	background: {{ $lighter_color }};
	color:#fff;
}

.btn.btn-radio.active {
	background:{{ $primary_color }};
	color:#fff;
}

#nprogress .bar {
	background:{{ $primary_color; }};
}

#nprogress .spinner-icon {
	border-top-color:{{ $primary_color; }};
	border-left-color:{{ $primary_color; }};
}
#nprogress .peg {
	box-shadow: 0 0 10px {{ $primary_color; }}, 0 0 5px {{ $primary_color; }};
}

.nav .caret, .nav>li>a, .navbar .navbar-nav>.active>a, .nav a:hover .caret{
	color:{{ $primary_color; }};
	border-top-color:{{ $primary_color; }};
	border-bottom-color:{{ $primary_color; }};
}

.navbar-nav>li>a.upload-btn, .navbar-inverse .navbar-nav>li>a:hover
{
	background:{{ $primary_color; }};
}

.active .nav-border-bottom{
	background:{{ $primary_color; }};
}

.form-control:focus{
	border-color:{{ $primary_color }};
}

a.spcl-button.color {
	background-color:{{ $primary_color }};
}

.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus{
	background:{{ $primary_color }};
}

ul.tags li a{
	background:{{ $primary_color }};
}

div.tagsinput span.tag{
	border:1px solid {{ $primary_color }};
	color:#fff;
	background:{{ $lighter_color }};
}

.table-striped>tbody>tr:first-child>th{
	background:{{ $primary_color }};
	border:0px;
	color:#fff;
}

.table-striped>tbody>tr:first-child{
	border:0px;
}
.table-striped>tbody>tr:nth-child(2)>td{
	border-top-color:{{ $light_color }};
}

.pagination>li>a{
	background:{{ $dark_color }};
}

.pagination>li>span, .pagination>.active>span, .pagination>li>a:hover, .pagination>.active>span:hover{
	background:{{ $light_color }};
}

.pagination>li>span:hover, .pagination>.disabled>span{
	background:{{ $lightest_color }};
	color:{{ $dark_color }};
}

.pagination>li>a, .pagination>li>span, .pagination>.disabled>span, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus, .pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
	border:1px solid {{ $primary_color }};
}

div.tagsinput span.tag a{
	color:{{ $dark_color }};
}

a.spcl-button.color:hover {
	background-color:{{ $lighter_color }};
	color:#fff;
}

.btn.btn-prev:hover, .btn.btn-next:hover{
	background:{{ $primary_color }};
}



/********** SECONDARY COLOR **********/
.home-media-like.active{
	background:{{ $secondary_color }};
}

p.home-like-count{
	color:{{ $secondary_color }};
}

a, a:hover, a:focus{
	color:{{ $secondary_color }};
}

.user-menu p {
	color:{{ $secondary_color }};
}

#next_media li a div.active, #next_media li a:hover div{
	border-color:{{ $secondary_color }};
}

.admin-block.active, .admin-block:hover{
	border-color:{{ $primary_color }};
}

h2.subheader{
	border-color:{{ $dark_color }};
	background:{{ $primary_color }};
}

.ouro:after {
	background-color:{{ $primary_color }};
}

.ouro {
	background-color:{{ $light_color }};
}

h2.subheader i{
	color:{{ $dark_color }};
}

.load-more-btn{
	border-bottom-color:{{ $dark_color }};
}

@if(isset($settings->random_bar_enabled) && $settings->random_bar_enabled == 0)

.navbar.gallery-sub-header{
	top:52px;
}

@else

@media (max-width: 991px){
	.navbar.gallery-sub-header{
		top:52px;
	}
}

@endif

{{ $settings->custom_css }}

</style>