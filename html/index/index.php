<?php
	include(HTML_DIR."overall/header.php");
	include(HTML_DIR."overall/menu.php");
?>
<section class="mbr-slider mbr-section mbr-section--no-padding carousel slide" data-ride="carousel" data-wrap="true" data-interval="5000" id="slider-c" style="background-color: rgb(255, 255, 255); margin-left: 180px; padding-top: 40px;">
    <div class="mbr-section__container">
        <div>
            <ol class="carousel-indicators">
                <li data-app-prevent-settings="" data-target="#slider-c" class="active" data-slide-to="0"></li>
                <li data-app-prevent-settings="" data-target="#slider-c" data-slide-to="1"></li>
                <li data-app-prevent-settings="" data-target="#slider-c" data-slide-to="2"></li>
                <li data-app-prevent-settings="" data-target="#slider-c" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height active" style="background-image: url(views/images/slide1.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-right mbr-box__magnet--sm-padding">
                        <div class="mbr-overlay" style="opacity: 0.1; background-color: rgb(255, 255, 255);"></div>                        
                        <div class=" container">
                            <div class="row">
                                <div class=" col-md-6 col-md-offset-5">  
                                    <div class="mbr-hero">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(views/images/slide2.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-left mbr-box__magnet--sm-padding">
                        <div class="mbr-overlay" style="opacity: 0.1; background-color: rgb(255, 255, 255);"></div>               
                        <div class=" container">
                            <div class="row">
                                <div class=" col-md-6 col-md-offset-1">  
                                    <div class="mbr-hero">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(views/images/slide3.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-center mbr-box__magnet--sm-padding">
                        <div class="mbr-overlay" style="opacity: 0.1; background-color: rgb(255, 255, 255);"></div> 
                        <div class=" container">
                            <div class="row">
                                <div class=" col-md-8 col-md-offset-2">  
                                    <div class="mbr-hero">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mbr-box mbr-section mbr-section--relative mbr-section--fixed-size mbr-section--bg-adapted item dark center mbr-section--full-height" style="background-image: url(views/images/slide4.jpg);">
                    <div class="mbr-box__magnet mbr-box__magnet--center-center mbr-box__magnet--sm-padding">
                        <div class="mbr-overlay" style="opacity: 0.1; background-color: rgb(255, 255, 255);"></div> 
                        <div class=" container">
                            <div class="row">
                                <div class=" col-md-8 col-md-offset-2">  
                                    <div class="mbr-hero">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a data-app-prevent-settings="" class="left carousel-control" role="button" data-slide="prev" href="#slider-c">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true" style="padding-top: 15px;"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a data-app-prevent-settings="" class="right carousel-control" role="button" data-slide="next" href="#slider-c">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true" style="padding-top: 15px;"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>
<?php  
	include(HTML_DIR."overall/footer.php");
?>