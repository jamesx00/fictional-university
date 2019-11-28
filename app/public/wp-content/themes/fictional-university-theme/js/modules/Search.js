import $ from 'jquery';

class Search {

	// 1. describe and create/initiate object
	constructor() {
		this.addSearchHTML();
		this.resultsDiv = $('#search-overlay__results');
		this.openButton = $(".js-search-trigger");
		this.closeButton = $(".search-overlay__close");
		this.searchOverlay = $('.search-overlay');
		this.searchFIeld = $('#search-term');
		this.events();
		this.isOverlayOpen = false;
		this.typingTimer;
		this.isSpinnerVisible = false;
	}

	// 2. events
	events() {
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));
		$(document).on('keydown', this.keyPressDispatcher.bind(this));
		this.searchFIeld.on('input', this.typingLogic.bind(this));
	}

	// 3. methods
	typingLogic(e) {

		clearTimeout(this.typingTimer);

		if (this.searchFIeld.val()) {
			// do something
			if (!this.isSpinnerVisible) {
				this.resultsDiv.html('<div class="spinner-loader"></div>');
				this.isSpinnerVisible = true;
				
			}

			this.typingTimer = setTimeout(this.getResults.bind(this), 750);

		}	else	{
			this.resultsDiv.html('');
			this.isSpinnerVisible = false;
		}


		
	}

	getResults() {
		$.getJSON(universityData['root_url'] + '/wp-json/university/v1/search?term=' + this.searchFIeld.val(), (results) => {
			this.resultsDiv.html(`
				<div class="row">
					<div class="one-third">
						<h2 class="search-overlay__section-title">General Information</h2>
						${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No information matched that search</p>' }
						${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.authorName ? `by ${item.authorName}` : ''}</li>`).join('')}
						${results.generalInfo.length ? '</ul>' : ''}
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Programs</h2>
						${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs matched that search <a href="${universityData.root_url}/programs">View all programs</a></p>` }
						${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
						${results.programs.length ? '</ul>' : ''}
						<h2 class="search-overlay__section-title">Professors</h2>
						${results.professors.length ? '<ul class="professor-cards">' : `<p>No professors matched that search</p>` }
						${results.professors.map(item => `
								<li class="professor-card__list-item">
									<a class="professor-card" href="${item.permalink}">
										<img class="professor-card__image" src="${item.image}">
										<span class="professor-card__name">${item.title}</span>
									</a>
								</li>
							`).join('')}
						${results.professors.length ? '</ul>' : ''}
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Campuses</h2>
						${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campuses matched that search <a href="${universityData.root_url}/campuses">View all campuses</a></p>` }
						${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
						${results.campuses.length ? '</ul>' : ''}
						<h2 class="search-overlay__section-title">Events</h2>
						${results.events.length ? '' : `<p>No events matched that search <a href="${universityData.root_url}/events">View all events</a></p>` }
						${results.events.map(item => `
								<div class="event-summary">
									<a class="event-summary__date t-center" href="${item.permalink}">
										<span class="event-summary__month">
											${item.month}
										</span>
										<span class="event-summary__day">
											${item.day}
										</span>  
									</a>
									<div class="event-summary__content">
										<h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
										<p>${item.description}<a href="${item.permalink}" class="nu gray"> Learn More</a></p>
									</div>
								</div>
							`).join('')}
						${results.events.length ? '' : ''}
					</div>
				</div>
			`);
			this.isSpinnerVisible = false;
		});
	}

	openOverlay() {
		this.searchOverlay.addClass('search-overlay--active');
		this.searchFIeld.val('');
		setTimeout(() => this.searchFIeld.focus(), 301);
		$('body').addClass('body-no-scroll');
		this.isOverlayOpen = true;
		return false;
	}

	closeOverlay() {
		this.searchOverlay.removeClass('search-overlay--active');
		$('body').removeClass('body-no-scroll');
		this.isOverlayOpen = false;
	}

	keyPressDispatcher(e) {
		if (e.keyCode == 83 & this.isOverlayOpen == false & !$('input, textarea').is(':focus')) {
			this.openOverlay();
		}

		if (e.keyCode == 27 & this.isOverlayOpen == true) {
			this.closeOverlay();
		}
	}

	addSearchHTML() {
		$("body").append(`
			<div class="search-overlay">
			<div class="search-overlay__top">
			<div class="container">
			<i class="fa fa-search fa-3x search-overlay__icon" aria-hidden="true"></i>
			<input class="search-term" type="text" name="" placeholder="What are you looking for" id="search-term">
			<i class="fa fa-window-close fa-3x search-overlay__close" aria-hidden="true"></i>
			</div>
			</div>
			<div class="container">
			<div id="search-overlay__results">

			</div>
			</div>
			</div>
			`);
	}

}


export default Search;