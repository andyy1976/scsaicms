// 通用脚本

// 搜索功能

function search() {

    var keywords = document.getElementById('keywords').value;

    if (keywords) {

        window.location.href = '/search.html?keywords=' + encodeURIComponent(keywords);

    }

}

// 回车键搜索

document.addEventListener('keypress', function(e) {

    if (e.key === 'Enter' && document.activeElement.id === 'keywords') {

        search();

    }

});

// 平滑滚动

function smoothScroll(target) {

    const element = document.querySelector(target);

    if (element) {

        element.scrollIntoView({

            behavior: 'smooth',

            block: 'start'

        });

    }

}

// 导航栏滚动效果

window.addEventListener('scroll', function() {

    const header = document.querySelector('.g_syhead');

    if (header) {

        if (window.scrollY > 50) {

            header.classList.add('scrolled');

        } else {

            header.classList.remove('scrolled');

        }

    }

});

// 回到顶部功能

function backToTop() {

    window.scrollTo({

        top: 0,

        behavior: 'smooth'

    });

}

// 侧边导航栏响应式调整

function adjustSideNav() {

    const sideNav = document.querySelector('.he_cubnav');

    if (sideNav) {

        if (window.innerWidth < 768) {

            sideNav.style.right = '10px';

        } else {

            sideNav.style.right = '30px';

        }

    }

}

// 滚动显示/隐藏回到顶部按钮

window.addEventListener('scroll', function() {

    const backTop = document.querySelector('.he_backtop');

    if (backTop) {

        if (window.scrollY > 300) {

            backTop.style.display = 'flex';

        } else {

            backTop.style.display = 'none';

        }

    }

});

// 弹窗功能

function openPopup() {

    const popup = document.querySelector('.mc_popup');

    if (popup) {

        popup.style.display = 'flex';

    }

}

function closePopup() {

    const popup = document.querySelector('.mc_popup');

    if (popup) {

        popup.style.display = 'none';

    }

}

// 点击弹窗外部关闭弹窗

document.addEventListener('click', function(e) {

    const popup = document.querySelector('.mc_popup');

    const popupCon = document.querySelector('.mc_popup_con');

    if (popup && !popupCon.contains(e.target)) {

        closePopup();

    }

});

// 表单验证

function validateForm(form) {

    const inputs = form.querySelectorAll('input[required], textarea[required]');

    let isValid = true;

    inputs.forEach(input => {

        if (!input.value.trim()) {

            input.style.borderColor = '#dc3545';

            isValid = false;

        } else {

            input.style.borderColor = '#ced4da';

        }

    });

    return isValid;

}

// 表单提交

document.addEventListener('submit', function(e) {

    if (e.target.tagName === 'FORM') {

        if (!validateForm(e.target)) {

            e.preventDefault();

            alert('请填写所有必填项');

        }

    }

});

// 图片懒加载

function lazyLoad() {

    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                const img = entry.target;

                img.src = img.dataset.src;

                img.removeAttribute('data-src');

                imageObserver.unobserve(img);

            }

        });

    });

    images.forEach(img => {

        imageObserver.observe(img);

    });

}

// 轮播图初始化

function initSlick() {

    if (typeof $ !== 'undefined' && $.fn.slick) {

        // 首页轮播

        $('.he_bannigul').slick({

            slidesToShow: 1,

            slidesToScroll: 1,

            autoplay: true,

            autoplaySpeed: 5000,

            dots: true,

            arrows: true,

            fade: true,

            speed: 1000,

            responsive: [

                {

                    breakpoint: 768,

                    settings: {

                        dots: false,

                        arrows: false

                    }

                }

            ]

        });

        // 产品推荐轮播

        if ($('.he_recomul').length > 0) {

            $('.he_recomul').slick({

                slidesToShow: 3,

                slidesToScroll: 1,

                autoplay: true,

                autoplaySpeed: 3000,

                dots: false,

                arrows: true,

                responsive: [

                    {

                        breakpoint: 992,

                        settings: {

                            slidesToShow: 2

                        }

                    },

                    {

                        breakpoint: 768,

                        settings: {

                            slidesToShow: 1

                        }

                    }

                ]

            });

        }

        // 解决方案轮播

        if ($('.he_solutiul').length > 0) {

            $('.he_solutiul').slick({

                slidesToShow: 2,

                slidesToScroll: 1,

                autoplay: true,

                autoplaySpeed: 4000,

                dots: false,

                arrows: true,

                responsive: [

                    {

                        breakpoint: 768,

                        settings: {

                            slidesToShow: 1

                        }

                    }

                ]

            });

        }

        // 客户案例轮播

        if ($('.he_caseul').length > 0) {

            $('.he_caseul').slick({

                slidesToShow: 3,

                slidesToScroll: 1,

                autoplay: true,

                autoplaySpeed: 5000,

                dots: false,

                arrows: true,

                responsive: [

                    {

                        breakpoint: 992,

                        settings: {

                            slidesToShow: 2

                        }

                    },

                    {

                        breakpoint: 768,

                        settings: {

                            slidesToShow: 1

                        }

                    }

                ]

            });

        }

    }

}

// 初始化函数

function init() {

    adjustSideNav();

    lazyLoad();

    initSlick();

    // 事件监听器

    const backTop = document.querySelector('.he_backtop');

    if (backTop) {

        backTop.addEventListener('click', backToTop);

    }

    const closeBtn = document.querySelector('.mc_popup_con_close');

    if (closeBtn) {

        closeBtn.addEventListener('click', closePopup);

    }

    // 窗口大小变化时调整

    window.addEventListener('resize', adjustSideNav);

}

// 文档加载完成后初始化

document.addEventListener('DOMContentLoaded', init);

// 页面加载完成后执行

window.addEventListener('load', function() {

    // 页面加载完成后的操作

});