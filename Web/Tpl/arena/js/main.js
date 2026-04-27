// 主要脚本

// 导航菜单

function initMenu() {

    // 下拉菜单

    const menuItems = document.querySelectorAll('.he_synavli');

    menuItems.forEach(item => {

        item.addEventListener('mouseenter', function() {

            const submenu = this.querySelector('.he_sypcuna');

            if (submenu) {

                submenu.style.opacity = '1';

                submenu.style.visibility = 'visible';

                submenu.style.transform = 'translateY(0)';

            }

        });

        item.addEventListener('mouseleave', function() {

            const submenu = this.querySelector('.he_sypcuna');

            if (submenu) {

                submenu.style.opacity = '0';

                submenu.style.visibility = 'hidden';

                submenu.style.transform = 'translateY(10px)';

            }

        });

    });

    // 移动端菜单

    const mobileMenuBtn = document.querySelector('.he_mobnavbtn');

    const mobileMenu = document.querySelector('.he_mobnav');

    if (mobileMenuBtn && mobileMenu) {

        mobileMenuBtn.addEventListener('click', function() {

            mobileMenu.classList.toggle('show');

        });

    }

}

// 滚动动画

function initScrollAnimation() {

    const animateElements = document.querySelectorAll('.wow');

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.add('animate-fade-in');

                observer.unobserve(entry.target);

            }

        });

    }, {

        threshold: 0.1

    });

    animateElements.forEach(element => {

        observer.observe(element);

    });

}

// 产品卡片悬停效果

function initProductHover() {

    const productCards = document.querySelectorAll('.he_recomli');

    productCards.forEach(card => {

        card.addEventListener('mouseenter', function() {

            this.style.transform = 'translateY(-10px)';

            this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';

        });

        card.addEventListener('mouseleave', function() {

            this.style.transform = 'translateY(0)';

            this.style.boxShadow = 'none';

        });

    });

}

// 解决方案卡片悬停效果

function initSolutionHover() {

    const solutionCards = document.querySelectorAll('.he_solutil');

    solutionCards.forEach(card => {

        card.addEventListener('mouseenter', function() {

            this.style.transform = 'translateY(-5px)';

            this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';

        });

        card.addEventListener('mouseleave', function() {

            this.style.transform = 'translateY(0)';

            this.style.boxShadow = 'none';

        });

    });

}

// 客户案例卡片悬停效果

function initCaseHover() {

    const caseCards = document.querySelectorAll('.he_caseli');

    caseCards.forEach(card => {

        card.addEventListener('mouseenter', function() {

            this.style.transform = 'scale(1.05)';

            this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';

        });

        card.addEventListener('mouseleave', function() {

            this.style.transform = 'scale(1)';

            this.style.boxShadow = 'none';

        });

    });

}

// 联系我们卡片悬停效果

function initContactHover() {

    const contactCards = document.querySelectorAll('.he_contactli');

    contactCards.forEach(card => {

        card.addEventListener('mouseenter', function() {

            this.style.transform = 'translateY(-5px)';

            this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';

        });

        card.addEventListener('mouseleave', function() {

            this.style.transform = 'translateY(0)';

            this.style.boxShadow = 'none';

        });

    });

}

// 按钮悬停效果

function initButtonHover() {

    const buttons = document.querySelectorAll('.btn, .he_recomlitbtn, .he_aboutribtn');

    buttons.forEach(button => {

        button.addEventListener('mouseenter', function() {

            this.style.transform = 'translateY(-2px)';

            this.style.boxShadow = '0 4px 12px rgba(0, 123, 255, 0.3)';

        });

        button.addEventListener('mouseleave', function() {

            this.style.transform = 'translateY(0)';

            this.style.boxShadow = 'none';

        });

    });

}

// 搜索框交互

function initSearch() {

    const searchBtn = document.querySelector('.he_sear');

    const searchBox = document.querySelector('.mc_search_xl');

    if (searchBtn && searchBox) {

        searchBtn.addEventListener('click', function(e) {

            e.stopPropagation();

            searchBox.style.opacity = '1';

            searchBox.style.visibility = 'visible';

            searchBox.style.transform = 'translateY(0)';

            const input = searchBox.querySelector('input');

            if (input) {

                input.focus();

            }

        });

        document.addEventListener('click', function(e) {

            if (!searchBtn.contains(e.target) && !searchBox.contains(e.target)) {

                searchBox.style.opacity = '0';

                searchBox.style.visibility = 'hidden';

                searchBox.style.transform = 'translateY(10px)';

            }

        });

    }

}

// 侧边导航栏交互

function initSideNav() {

    const sideNavItems = document.querySelectorAll('.he_cubnavli');

    sideNavItems.forEach(item => {

        item.addEventListener('mouseenter', function() {

            const tooltip = this.querySelector('.he_cubnavli_a_te');

            if (tooltip) {

                tooltip.style.opacity = '1';

                tooltip.style.visibility = 'visible';

                tooltip.style.right = '65px';

            }

        });

        item.addEventListener('mouseleave', function() {

            const tooltip = this.querySelector('.he_cubnavli_a_te');

            if (tooltip) {

                tooltip.style.opacity = '0';

                tooltip.style.visibility = 'hidden';

                tooltip.style.right = '60px';

            }

        });

    });

}

// 页面加载动画

function initPageLoad() {

    window.addEventListener('load', function() {

        document.body.classList.add('loaded');

    });

}

// 响应式调整

function initResponsive() {

    function adjustLayout() {

        const width = window.innerWidth;

        // 调整导航栏

        const nav = document.querySelector('.he_synavul');

        const mobileNav = document.querySelector('.he_mobnav');

        if (width < 992) {

            if (nav) nav.style.display = 'none';

            if (mobileNav) mobileNav.style.display = 'block';

        } else {

            if (nav) nav.style.display = 'flex';

            if (mobileNav) mobileNav.style.display = 'none';

        }

        // 调整轮播图

        const banner = document.querySelector('.he_banner');

        if (banner) {

            if (width < 768) {

                banner.style.height = '300px';

            } else if (width < 1200) {

                banner.style.height = '400px';

            } else {

                banner.style.height = '500px';

            }

        }

    }

    // 初始调整

    adjustLayout();

    // 窗口大小变化时调整

    window.addEventListener('resize', adjustLayout);

}

// 数字员工功能

function initDigitalEmployee() {

    const digitalEmployeeBtn = document.querySelector('.digital-employee-btn');

    const digitalEmployeePanel = document.querySelector('.digital-employee-panel');

    if (digitalEmployeeBtn && digitalEmployeePanel) {

        digitalEmployeeBtn.addEventListener('click', function() {

            digitalEmployeePanel.classList.toggle('show');

        });

    }

}

// 语言切换

function initLanguageSwitch() {

    const langSwitcher = document.querySelector('.lang-switcher');

    const langOptions = document.querySelector('.lang-options');

    if (langSwitcher && langOptions) {

        langSwitcher.addEventListener('click', function(e) {

            e.stopPropagation();

            langOptions.classList.toggle('show');

        });

        document.addEventListener('click', function(e) {

            if (!langSwitcher.contains(e.target) && !langOptions.contains(e.target)) {

                langOptions.classList.remove('show');

            }

        });

    }

}

// 初始化所有功能

function initAll() {

    initMenu();

    initScrollAnimation();

    initProductHover();

    initSolutionHover();

    initCaseHover();

    initContactHover();

    initButtonHover();

    initSearch();

    initSideNav();

    initPageLoad();

    initResponsive();

    initDigitalEmployee();

    initLanguageSwitch();

}

// 文档加载完成后初始化

document.addEventListener('DOMContentLoaded', initAll);