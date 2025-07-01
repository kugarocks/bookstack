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
        
        // Create mobile menu container
        this.createMobileMenuContainer();
        // Prepare menu content during initialization to avoid processing on each click
        this.prepareMobileMenuContent();
    }

    createMobileMenuContainer() {
        // Create mobile menu container
        this.mobileMenuContainer = document.createElement('div');
        this.mobileMenuContainer.id = 'mobile-menu-body';
        this.mobileMenuContainer.className = 'mobile-menu-body-container';
        this.mobileMenuContainer.style.display = 'none';
        
        // Record original content
        this.originalContent = null;
        
        // Insert into content container
        const contentDiv = document.getElementById('content');
        if (contentDiv) {
            contentDiv.insertBefore(this.mobileMenuContainer, contentDiv.firstChild);
        }
    }

    prepareMobileMenuContent() {
        // Only process menu content once during initialization
        const menuClone = this.menu.cloneNode(true);
        menuClone.classList.remove('header-links');
        menuClone.classList.add('mobile-menu-content');
        
        // Convert a tags in .links to li structure
        const linksContainer = menuClone.querySelector('.links');
        if (linksContainer) {
            const links = Array.from(linksContainer.querySelectorAll('a'));
            const ul = document.createElement('ul');
            
            links.forEach(link => {
                // Remove hide-over-l class to ensure display on mobile
                link.classList.remove('hide-over-l');
                const li = document.createElement('li');
                li.appendChild(link);
                ul.appendChild(li);
            });
            
            // Replace .links container with ul
            linksContainer.parentNode.replaceChild(ul, linksContainer);
        }
        
        // Handle dropdown-container
        const dropdownContainer = menuClone.querySelector('.dropdown-container');
        if (dropdownContainer) {
            // Hide username section
            const userName = dropdownContainer.querySelector('.user-name');
            if (userName) {
                userName.style.display = 'none';
            }
            
            // Ensure dropdown menu is expanded
            const dropdownMenu = dropdownContainer.querySelector('ul');
            if (dropdownMenu) {
                dropdownMenu.style.display = 'block';
            }
            
            // Remove desktop click events
            const dropdownToggle = dropdownContainer.querySelector('[refs*="dropdown@toggle"]');
            if (dropdownToggle) {
                dropdownToggle.removeAttribute('refs');
                dropdownToggle.style.cursor = 'default';
            }
            
            // Merge dropdown-container ul content into main ul
            if (dropdownMenu) {
                const mainUl = menuClone.querySelector('ul');
                if (mainUl && dropdownMenu !== mainUl) {
                    // Add dropdown li items to main ul
                    Array.from(dropdownMenu.children).forEach(li => {
                        mainUl.appendChild(li);
                    });
                    // Remove dropdown container
                    dropdownContainer.remove();
                }
            }
        }
        
        this.mobileMenuContainer.appendChild(menuClone);
    }

    onToggle(event) {
        this.open = !this.open;
        
        if (this.open) {
            // Directly show prepared menu without reprocessing
            this.showMobileMenu();
        } else {
            // Hide mobile menu and show original content
            this.hideMobileMenu();
        }
        
        this.toggleButton.setAttribute('aria-expanded', this.open ? 'true' : 'false');
        
        if (this.open) {
            this.elem.addEventListener('keydown', this.onKeyDown);
            window.addEventListener('click', this.onWindowClick);
        } else {
            this.elem.removeEventListener('keydown', this.onKeyDown);
            window.removeEventListener('click', this.onWindowClick);
        }
        event.stopPropagation();
    }

    showMobileMenu() {
        const contentDiv = document.getElementById('content');
        if (!contentDiv) return;
        
        // Save original content
        if (!this.originalContent) {
            this.originalContent = Array.from(contentDiv.children)
                .filter(child => child.id !== 'mobile-menu-body');
        }
        
        // Hide original content
        this.originalContent.forEach(child => {
            child.style.display = 'none';
        });
        
        // Show mobile menu
        this.mobileMenuContainer.style.display = 'block';
    }

    hideMobileMenu() {
        // Hide mobile menu
        this.mobileMenuContainer.style.display = 'none';
        
        // Show original content
        if (this.originalContent) {
            this.originalContent.forEach(child => {
                child.style.display = '';
            });
        }
    }

    onKeyDown(event) {
        if (event.code === 'Escape') {
            this.onToggle(event);
        }
    }

    onWindowClick(event) {
        // Close menu if click is outside menu container
        if (!this.mobileMenuContainer.contains(event.target) && !this.elem.contains(event.target)) {
            this.onToggle(event);
        }
    }

}
