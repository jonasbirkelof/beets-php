/**
 * Toggle Sidebar
 * 
 * Adds or removes a class 'sidebar-show' to the sidebar.
 * Optional sidebar ID can be passed. Default is the first '.bl-sidebar' inside of '#beets-layout'.
 */
window.toggleSidebar = function (sidebarId = null) {
	var sidebar = sidebarId ? document.getElementById(sidebarId) : document.getElementById('beets-layout').getElementsByClassName('bl__sidebar')[0];

	if (sidebar.classList.contains('sidebar-show')) {
		sidebar.classList.remove('sidebar-show');

		// Set a hiding class that is used for the animation, remove after 300ms
		sidebar.classList.add('sidebar-hiding');
		setTimeout(() => {
			sidebar.classList.remove('sidebar-hiding');
		}, 300);
	} else {
		sidebar.classList.add('sidebar-show');
	}
}

/**
 * Toggle Submenu
 */
window.toggleSubmenu = function (id) {
	var element = document.getElementById(id);
	
	element.parentElement.classList.toggle("open");
	element.classList.toggle("active");
}

/**
 * Toggle Header
 * 
 * Toggles the header navigation by first setting the containers actual size in px
 * before transitioning, since 'auto' can not be used for this.
 * 
 * The toggle functionality consists of the three functions below:
 * - toggleHeader()
 * - collapseHeader()
 * - expandHeader()
 * 
 * Ref: https://css-tricks.com/using-css-transitions-auto-dimensions/#aa-technique-3-javascript
 */
window.toggleHeader = function (navId) {
	var nav = document.getElementById(navId);
	var isExpanded = nav.getAttribute('data-bcss-collapsed') === 'false';

	if(isExpanded) {
		collapseHeader(nav)
		nav.setAttribute('data-bcss-collapsed', 'true')
	} else {
		nav.style.height = 0 + 'px';
		expandHeader(nav)
	}
}

function collapseHeader(element) {
	// get the height of the element's inner content, regardless of its actual size
	var navHeight = element.scrollHeight;

	element.classList.remove('show');

	// Set a hiding class that is used for the animation, remove after 300ms
	element.classList.add('hiding');
	setTimeout(() => {
		element.classList.remove('hiding');
	}, 300);

	// temporarily disable all css transitions
	var elementTransition = element.style.transition;
	element.style.transition = '';

	// on the next frame (as soon as the previous style change has taken effect),
	// explicitly set the element's height to its current pixel height, so we 
	// aren't transitioning out of 'auto'
	requestAnimationFrame(function() {
		element.style.height = navHeight + 'px';
		element.style.transition = elementTransition;

		// on the next frame (as soon as the previous style change has taken effect),
		// have the element transition to height: 0
		requestAnimationFrame(function() {
			element.style.height = 0 + 'px';
		});
	});
		
	// mark the section as "currently collapsed"
	element.setAttribute('data-bcss-collapsed', 'true');
}

function expandHeader(element) {
	element.classList.add('showing');

	// get the height of the element's inner content, regardless of its actual size
	var navHeight = element.scrollHeight;

	// have the element transition to the height of its inner content
	element.style.height = navHeight + 'px';

	setTimeout(() => {
		element.classList.remove('showing');
		element.classList.add('show');
		element.style.height = null;
	}, 300);	

	// when the next css transition finishes (which should be the one we just triggered)
	element.addEventListener('transitionend', function(e) {
		// remove this event listener so it only gets triggered once
		element.removeEventListener('transitionend', arguments.callee);
	});

	// mark the section as "currently not collapsed"
	element.setAttribute('data-bcss-collapsed', 'false');
}