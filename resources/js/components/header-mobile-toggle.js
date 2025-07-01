import {Component} from './component';

export class HeaderMobileToggle extends Component {

    setup() {
        this.elem = this.$el;
        this.toggleButton = this.$refs.toggle;
        this.menu = this.$refs.menu;
        this.open = false;

        this.toggleButton.addEventListener('click', this.onToggle.bind(this));
        this.onWindowClick = this.onWindowClick.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);
        
        this.initMobileMenu();
    }

    initMobileMenu() {
        // Create container
        this.mobileMenuContainer = document.createElement('div');
        this.mobileMenuContainer.id = 'mobile-menu-body';
        this.mobileMenuContainer.className = 'mobile-menu-body-container';
        this.mobileMenuContainer.style.display = 'none';
        
        const contentDiv = document.getElementById('content');
        if (contentDiv) {
            contentDiv.insertBefore(this.mobileMenuContainer, contentDiv.firstChild);
        }

        // Prepare content
        const menuClone = this.menu.cloneNode(true);
        menuClone.classList.remove('header-links');
        menuClone.classList.add('mobile-menu-content');
        
        this.processLinks(menuClone);
        this.processDropdown(menuClone);
        
        this.mobileMenuContainer.appendChild(menuClone);
    }

    processLinks(menuClone) {
        const linksContainer = menuClone.querySelector('.links');
        if (!linksContainer) return;

        const ul = document.createElement('ul');
        Array.from(linksContainer.querySelectorAll('a')).forEach(link => {
            link.classList.remove('hide-over-l');
            const li = document.createElement('li');
            li.appendChild(link);
            ul.appendChild(li);
        });
        linksContainer.parentNode.replaceChild(ul, linksContainer);
    }

    processDropdown(menuClone) {
        const dropdownContainer = menuClone.querySelector('.dropdown-container');
        if (!dropdownContainer) return;

        // Hide username and show dropdown
        const userName = dropdownContainer.querySelector('.user-name');
        const dropdownMenu = dropdownContainer.querySelector('ul');
        const dropdownToggle = dropdownContainer.querySelector('[refs*="dropdown@toggle"]');
        
        if (userName) userName.style.display = 'none';
        if (dropdownMenu) dropdownMenu.style.display = 'block';
        if (dropdownToggle) {
            dropdownToggle.removeAttribute('refs');
            dropdownToggle.style.cursor = 'default';
        }

        // Merge dropdown items into main ul
        const mainUl = menuClone.querySelector('ul');
        if (dropdownMenu && mainUl && dropdownMenu !== mainUl) {
            Array.from(dropdownMenu.children).forEach(li => mainUl.appendChild(li));
            dropdownContainer.remove();
        }
    }

    onToggle(event) {
        this.open = !this.open;
        this.toggleMenu();
        this.toggleButton.setAttribute('aria-expanded', this.open ? 'true' : 'false');
        this.toggleEventListeners();
        event.stopPropagation();
    }

    toggleMenu() {
        const contentDiv = document.getElementById('content');
        if (!contentDiv) return;

        if (this.open) {
            // Save and hide original content, show menu
            if (!this.originalContent) {
                this.originalContent = Array.from(contentDiv.children)
                    .filter(child => child.id !== 'mobile-menu-body');
            }
            this.originalContent.forEach(child => child.style.display = 'none');
            this.mobileMenuContainer.style.display = 'block';
        } else {
            // Hide menu, show original content
            this.mobileMenuContainer.style.display = 'none';
            if (this.originalContent) {
                this.originalContent.forEach(child => child.style.display = '');
            }
        }
    }

    toggleEventListeners() {
        const method = this.open ? 'addEventListener' : 'removeEventListener';
        this.elem[method]('keydown', this.onKeyDown);
        window[method]('click', this.onWindowClick);
    }

    onKeyDown(event) {
        if (event.code === 'Escape') {
            this.onToggle(event);
        }
    }

    onWindowClick(event) {
        if (!this.mobileMenuContainer.contains(event.target) && !this.elem.contains(event.target)) {
            this.onToggle(event);
        }
    }

}
