document.addEventListener('DOMContentLoaded', () => {
	const translations = {
		ro: {
			changeLanguage: 'Schimba limba',
			communities: 'Comunitati',
			comingSoon: 'In curand',
			createCommunity: 'Creeaza comunitate',
			explore: 'Exploreaza',
			feed: 'Feed',
			fresh: 'Proaspat',
			guestBrowsing: 'Navigare ca oaspete',
			home: 'Acasa',
			hot: 'Hot',
			info: 'Info',
			join: 'Alatura-te',
			joinLoginRequired: 'Autentifica-te pentru a te alatura',
			login: 'Autentificare',
			loginForNotifications: 'Autentifica-te pentru a vedea notificarile.',
			members: 'membri',
			menu: 'Meniu',
			new: 'Nou',
			newPost: 'Postare noua',
			noExploreContent: 'Nu exista continut de explorat inca.',
			noNotifications: 'Nu ai notificari noi.',
			noPopularPosts: 'Nu exista postari populare inca.',
			noPosts: 'Nu exista postari inca.',
			noSavedPosts: 'Nu ai postari salvate momentan.',
			noTrends: 'Nicio tendinta inca.',
			notifications: 'Notificari',
			notificationsRo: 'Notificari',
			popular: 'Popular',
			profile: 'Profil',
			quickHelp: 'Ajutor rapid',
			register: 'Inregistrare',
			saved: 'Salvate',
			savedPosts: 'Postari salvate',
			search: 'Cauta',
			settings: 'Setari',
			suggestedCommunities: 'Comunitati sugerate',
			support: 'Suport',
			supportTipContact: 'Trimite un mesaj prin pagina de contact.',
			supportTipFeed: 'Revino in feed pentru actualizari noi.',
			supportTipSettings: 'Verifica datele contului in Setari.',
			toggleTheme: 'Comuta tema',
			top: 'Top',
			trending: 'In trend',
			trendingToday: 'In trend astazi',
			upvotes: 'voturi',
		},
		en: {
			changeLanguage: 'Change language',
			communities: 'Communities',
			comingSoon: 'Coming soon',
			createCommunity: 'Create community',
			explore: 'Explore',
			feed: 'Feed',
			fresh: 'Fresh',
			guestBrowsing: 'Browsing as guest',
			home: 'Home',
			hot: 'Hot',
			info: 'Info',
			join: 'Join',
			joinLoginRequired: 'Sign in to join',
			login: 'Sign in',
			loginForNotifications: 'Sign in to view notifications.',
			members: 'members',
			menu: 'Menu',
			new: 'New',
			newPost: 'New post',
			noExploreContent: 'There is no content to explore yet.',
			noNotifications: 'You have no new notifications.',
			noPopularPosts: 'There are no popular posts yet.',
			noPosts: 'No posts yet',
			noSavedPosts: 'You have no saved posts yet.',
			noTrends: 'No trends yet.',
			notifications: 'Notifications',
			notificationsRo: 'Notifications',
			popular: 'Popular',
			profile: 'Profile',
			quickHelp: 'Quick help',
			register: 'Register',
			saved: 'Saved',
			savedPosts: 'Saved posts',
			search: 'Search',
			settings: 'Settings',
			suggestedCommunities: 'Suggested communities',
			support: 'Support',
			supportTipContact: 'Send a message through the contact page.',
			supportTipFeed: 'Return to the feed for new updates.',
			supportTipSettings: 'Check your account details in Settings.',
			toggleTheme: 'Toggle theme',
			top: 'Top',
			trending: 'Trending',
			trendingToday: 'Trending today',
			upvotes: 'upvotes',
		},
		ru: {
			changeLanguage: 'Сменить язык',
			communities: 'Сообщества',
			explore: 'Обзор',
			feed: 'Лента',
			fresh: 'Новое',
			guestBrowsing: 'Просмотр как гость',
			home: 'Главная',
			hot: 'Горячее',
			info: 'Инфо',
			join: 'Вступить',
			joinLoginRequired: 'Войдите, чтобы вступить',
			login: 'Войти',
			loginForNotifications: 'Войдите, чтобы увидеть уведомления.',
			members: 'участников',
			menu: 'Меню',
			new: 'Новое',
			newPost: 'Новый пост',
			noExploreContent: 'Пока нечего исследовать.',
			noNotifications: 'Новых уведомлений нет.',
			noPopularPosts: 'Популярных постов пока нет.',
			noPosts: 'Постов пока нет',
			noSavedPosts: 'У вас пока нет сохраненных постов.',
			noTrends: 'Трендов пока нет.',
			notifications: 'Уведомления',
			notificationsRo: 'Уведомления',
			popular: 'Популярное',
			profile: 'Профиль',
			quickHelp: 'Быстрая помощь',
			register: 'Регистрация',
			saved: 'Сохраненное',
			savedPosts: 'Сохраненные посты',
			search: 'Поиск',
			settings: 'Настройки',
			suggestedCommunities: 'Рекомендуемые сообщества',
			support: 'Поддержка',
			supportTipContact: 'Отправьте сообщение через страницу контактов.',
			supportTipFeed: 'Вернитесь в ленту за новыми обновлениями.',
			supportTipSettings: 'Проверьте данные аккаунта в настройках.',
			toggleTheme: 'Переключить тему',
			top: 'Топ',
			trending: 'В тренде',
			trendingToday: 'Сегодня в тренде',
			upvotes: 'голосов',
		},
	};

	Object.assign(translations.ro, {
		about: 'Despre',
		aboutBody: 'user-platform ajuta utilizatorii sa creeze comunitati, sa publice postari si sa pastreze conversatiile organizate intr-un singur loc.',
		aboutKicker: 'Platforma sociala',
		aboutTitle: 'Un spatiu pentru comunitati si discutii',
		contact: 'Contact',
		featureAuth: 'Conturi cu inregistrare, autentificare, deconectare si sesiune de utilizator.',
		featureCommunities: 'Comunitati publice sau private, cu iconita prin link si administrare pentru creator.',
		featureInteractions: 'Reactii, comentarii, raspunsuri si salvare pentru postari.',
		featurePosts: 'Postari create de utilizatori autentificati, editabile doar de autor.',
		featurePreferences: 'Tema dark/light si schimbarea limbii in romana, engleza sau rusa.',
		features: 'Functionalitati',
		mainFeatures: 'Functionalitati principale',
		projectPurpose: 'Scopul aplicatiei',
		projectPurposeOne: 'Conecteaza utilizatorii in jurul unor comunitati publice sau private.',
		projectPurposeTwo: 'Permite publicarea de continut doar pentru conturi autentificate.',
		projectPurposeThree: 'Pastreaza datele in fisiere JSON pentru conturi, comunitati, postari si mesaje.',
		startBody: 'user-platform este un spatiu unde utilizatorii pot crea comunitati, pot publica postari si pot interactiona prin comentarii, reactii si continut salvat.',
		startKicker: 'Platforma sociala',
		startTitle: 'Comunitati, postari si discutii intr-un singur loc',
	});

	Object.assign(translations.en, {
		about: 'About',
		aboutBody: 'user-platform helps users create communities, publish posts, and keep conversations organized in one place.',
		aboutKicker: 'Social platform',
		aboutTitle: 'A space for communities and discussions',
		contact: 'Contact',
		featureAuth: 'Accounts with registration, sign in, logout, and user sessions.',
		featureCommunities: 'Public or private communities, image-link icons, and creator management.',
		featureInteractions: 'Reactions, comments, replies, and saving for posts.',
		featurePosts: 'Posts created by signed-in users and editable only by the author.',
		featurePreferences: 'Dark/light theme and language switching in Romanian, English, or Russian.',
		features: 'Features',
		mainFeatures: 'Main features',
		projectPurpose: 'Application purpose',
		projectPurposeOne: 'Connect users around public or private communities.',
		projectPurposeTwo: 'Allow content publishing only for signed-in accounts.',
		projectPurposeThree: 'Store data in JSON files for accounts, communities, posts, and messages.',
		startBody: 'user-platform is a place where users can create communities, publish posts, and interact through comments, reactions, and saved content.',
		startKicker: 'Social platform',
		startTitle: 'Communities, posts, and discussions in one place',
	});

	translations.ru = {
		about: 'О проекте',
		aboutBody: 'user-platform помогает пользователям создавать сообщества, публиковать посты и хранить обсуждения в одном месте.',
		aboutKicker: 'Социальная платформа',
		aboutTitle: 'Пространство для сообществ и обсуждений',
		changeLanguage: 'Сменить язык',
		communities: 'Сообщества',
		comingSoon: 'Скоро',
		contact: 'Контакт',
		createCommunity: 'Создать сообщество',
		explore: 'Обзор',
		featureAuth: 'Аккаунты с регистрацией, входом, выходом и пользовательской сессией.',
		featureCommunities: 'Публичные или приватные сообщества, иконки по ссылке и управление создателем.',
		featureInteractions: 'Реакции, комментарии, ответы и сохранение постов.',
		featurePosts: 'Посты создаются авторизованными пользователями и редактируются только автором.',
		featurePreferences: 'Темная/светлая тема и выбор языка: румынский, английский или русский.',
		features: 'Функции',
		feed: 'Лента',
		fresh: 'Новое',
		guestBrowsing: 'Просмотр как гость',
		home: 'Главная',
		hot: 'Горячее',
		join: 'Вступить',
		joinLoginRequired: 'Войдите, чтобы вступить',
		login: 'Войти',
		loginForNotifications: 'Войдите, чтобы увидеть уведомления.',
		mainFeatures: 'Основные функции',
		members: 'участников',
		menu: 'Меню',
		new: 'Новое',
		newPost: 'Новый пост',
		noExploreContent: 'Пока нечего исследовать.',
		noNotifications: 'Новых уведомлений нет.',
		noPopularPosts: 'Популярных постов пока нет.',
		noPosts: 'Постов пока нет',
		noSavedPosts: 'У вас пока нет сохраненных постов.',
		noTrends: 'Трендов пока нет.',
		notifications: 'Уведомления',
		notificationsRo: 'Уведомления',
		popular: 'Популярное',
		profile: 'Профиль',
		projectPurpose: 'Цель приложения',
		projectPurposeOne: 'Объединять пользователей вокруг публичных или приватных сообществ.',
		projectPurposeTwo: 'Разрешать публикацию контента только авторизованным аккаунтам.',
		projectPurposeThree: 'Хранить данные в JSON-файлах для аккаунтов, сообществ, постов и сообщений.',
		quickHelp: 'Быстрая помощь',
		register: 'Регистрация',
		saved: 'Сохраненное',
		savedPosts: 'Сохраненные посты',
		search: 'Поиск',
		settings: 'Настройки',
		startBody: 'user-platform - это место, где пользователи могут создавать сообщества, публиковать посты и взаимодействовать через комментарии, реакции и сохраненный контент.',
		startKicker: 'Социальная платформа',
		startTitle: 'Сообщества, посты и обсуждения в одном месте',
		suggestedCommunities: 'Рекомендуемые сообщества',
		support: 'Поддержка',
		supportTipContact: 'Отправьте сообщение через страницу контактов.',
		supportTipFeed: 'Вернитесь в ленту за новыми обновлениями.',
		supportTipSettings: 'Проверьте данные аккаунта в настройках.',
		toggleTheme: 'Переключить тему',
		top: 'Топ',
		trending: 'В тренде',
		trendingToday: 'Сегодня в тренде',
		upvotes: 'голосов',
	};

	const langCodes = { ro: 'RO', en: 'EN', ru: 'RU' };
	const getSavedLanguage = () => {
		try {
			const saved = localStorage.getItem('preferredLanguage') || 'ro';
			return translations[saved] ? saved : 'ro';
		} catch (error) {
			return 'ro';
		}
	};

	const applyLanguage = (lang) => {
		const dictionary = translations[lang] || translations.ro;
		document.documentElement.lang = lang;

		document.querySelectorAll('[data-i18n]').forEach((element) => {
			const key = element.getAttribute('data-i18n');
			if (key && dictionary[key]) {
				element.textContent = dictionary[key];
			}
		});

		document.querySelectorAll('[data-i18n-placeholder]').forEach((element) => {
			const key = element.getAttribute('data-i18n-placeholder');
			if (key && dictionary[key]) {
				element.setAttribute('placeholder', dictionary[key]);
			}
		});

		document.querySelectorAll('[data-i18n-aria-label]').forEach((element) => {
			const key = element.getAttribute('data-i18n-aria-label');
			if (key && dictionary[key]) {
				element.setAttribute('aria-label', dictionary[key]);
			}
		});

		document.querySelectorAll('[data-i18n-title]').forEach((element) => {
			const key = element.getAttribute('data-i18n-title');
			if (key && dictionary[key]) {
				element.setAttribute('title', dictionary[key]);
			}
		});

		const langLabel = document.querySelector('[data-lang-label]');
		if (langLabel) {
			langLabel.textContent = langCodes[lang] || lang.toUpperCase();
		}

		document.querySelectorAll('[data-lang]').forEach((option) => {
			option.setAttribute('aria-selected', option.getAttribute('data-lang') === lang ? 'true' : 'false');
		});
	};

	const searchInput = document.querySelector('[data-server-search]') || document.querySelector('#server-search');
	const serverList = document.querySelector('[data-server-list]') || document.querySelector('#server-list');
	const postCards = Array.from(document.querySelectorAll('[data-post-title]'));

	const applyPostSearch = (query) => {
		const normalizedQuery = query.trim().toLowerCase();
		let firstMatch = null;

		postCards.forEach((post) => {
			const title = (post.getAttribute('data-post-title') || '').toLowerCase();
			const isMatch = normalizedQuery !== '' && title.includes(normalizedQuery);
			post.classList.toggle('post-card--search-match', isMatch);
			if (isMatch && !firstMatch) {
				firstMatch = post;
			}
		});

		return firstMatch;
	};

	const goToPostSearchResult = (query) => {
		const firstMatch = applyPostSearch(query);
		if (firstMatch) {
			firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
			window.history.replaceState(null, '', `#${firstMatch.id}`);
			return;
		}

		if (query.trim() !== '' && postCards.length === 0) {
			window.location.href = `index.php?search=${encodeURIComponent(query.trim())}`;
		}
	};

	if (searchInput && serverList && !searchInput.disabled) {
		const serverItems = Array.from(serverList.querySelectorAll('[data-server-name]'));

		searchInput.addEventListener('input', () => {
			const query = searchInput.value.trim().toLowerCase();
			serverItems.forEach((item) => {
				const name = (item.getAttribute('data-server-name') || '').toLowerCase();
				item.style.display = name.includes(query) ? '' : 'none';
			});
		});
	}

	if (searchInput && !searchInput.disabled) {
		const params = new URLSearchParams(window.location.search);
		const initialSearch = params.get('search') || '';
		if (initialSearch !== '') {
			searchInput.value = initialSearch;
			const firstMatch = applyPostSearch(initialSearch);
			if (firstMatch) {
				window.setTimeout(() => {
					firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
				}, 80);
			}
		}

		searchInput.addEventListener('input', () => {
			applyPostSearch(searchInput.value);
		});

		searchInput.addEventListener('keydown', (event) => {
			if (event.key === 'Enter') {
				event.preventDefault();
				goToPostSearchResult(searchInput.value);
			}
		});
	}

	const sortTabs = Array.from(document.querySelectorAll('.sort-tab'));
	if (sortTabs.length) {
		sortTabs.forEach((tab) => {
			tab.addEventListener('click', () => {
				if (tab.disabled) {
					return;
				}
				sortTabs.forEach((item) => item.classList.remove('active'));
				tab.classList.add('active');
			});
		});
	}

	const applyTheme = (theme) => {
		const isLight = theme === 'light';
		document.body.classList.toggle('theme-light', isLight);
		const themeToggle = document.querySelector('[data-theme-toggle]');
		if (themeToggle) {
			themeToggle.setAttribute('aria-pressed', String(!isLight));
		}
	};

	const getSavedTheme = () => {
		try {
			return localStorage.getItem('preferredTheme') === 'light' ? 'light' : 'dark';
		} catch (error) {
			return 'dark';
		}
	};

	applyTheme(getSavedTheme());

	const themeToggle = document.querySelector('[data-theme-toggle]');
	if (themeToggle) {
		themeToggle.addEventListener('click', () => {
			const nextTheme = document.body.classList.contains('theme-light') ? 'dark' : 'light';
			applyTheme(nextTheme);
			try {
				localStorage.setItem('preferredTheme', nextTheme);
			} catch (error) {
			}
		});
	}

	const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
	const setSidebarCollapsed = (collapsed) => {
		document.body.classList.toggle('sidebar-collapsed', collapsed);
		if (sidebarToggle) {
			sidebarToggle.setAttribute('aria-expanded', String(!collapsed));
		}
	};

	if (sidebarToggle) {
		let isSidebarCollapsed = false;
		try {
			isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
		} catch (error) {
			isSidebarCollapsed = false;
		}
		setSidebarCollapsed(isSidebarCollapsed);

		sidebarToggle.addEventListener('click', () => {
			const collapsed = !document.body.classList.contains('sidebar-collapsed');
			setSidebarCollapsed(collapsed);
			try {
				localStorage.setItem('sidebarCollapsed', String(collapsed));
			} catch (error) {
			}
		});
	}

	const infoToggle = document.querySelector('[data-info-toggle]');
	const infoMenu = document.querySelector('[data-info-menu]');
	if (infoToggle && infoMenu) {
		infoToggle.addEventListener('click', () => {
			const isOpen = !infoMenu.hidden;
			infoMenu.hidden = isOpen;
			infoToggle.setAttribute('aria-expanded', String(!isOpen));
			infoToggle.closest('[data-info-nav]')?.classList.toggle('open', !isOpen);
		});
	}

	const langSwitcher = document.querySelector('[data-lang-switcher]');
	if (langSwitcher) {
		const langToggle = langSwitcher.querySelector('[data-lang-toggle]');
		const langMenu = langSwitcher.querySelector('[data-lang-menu]');
		const langOptions = Array.from(langSwitcher.querySelectorAll('[data-lang]'));

		const closeMenu = () => {
			if (!langMenu || !langToggle) {
				return;
			}
			langMenu.hidden = true;
			langToggle.setAttribute('aria-expanded', 'false');
		};

		const openMenu = () => {
			if (!langMenu || !langToggle) {
				return;
			}
			langMenu.hidden = false;
			langToggle.setAttribute('aria-expanded', 'true');
		};

		langToggle?.addEventListener('click', (event) => {
			event.stopPropagation();
			if (langMenu?.hidden) {
				openMenu();
			} else {
				closeMenu();
			}
		});

		langOptions.forEach((option) => {
			option.addEventListener('click', () => {
				const lang = option.getAttribute('data-lang') || 'ro';
				try {
					localStorage.setItem('preferredLanguage', lang);
				} catch (error) {
				}
				applyLanguage(lang);
				closeMenu();
			});
		});

		document.addEventListener('click', (event) => {
			if (!langSwitcher.contains(event.target)) {
				closeMenu();
			}
		});
	}

	applyLanguage(getSavedLanguage());

	document.querySelectorAll('[data-confirm-submit]').forEach((form) => {
		form.addEventListener('submit', (event) => {
			const message = form.getAttribute('data-confirm-submit') || 'Confirmi actiunea?';
			if (!window.confirm(message)) {
				event.preventDefault();
			}
		});
	});

	document.querySelectorAll('[data-comments-toggle]').forEach((button) => {
		button.addEventListener('click', () => {
			const post = button.closest('.post-card');
			const panel = post?.querySelector('[data-comments-panel]');
			if (!panel) {
				return;
			}
			panel.hidden = !panel.hidden;
			button.classList.toggle('active', !panel.hidden);
		});
	});

	document.querySelectorAll('[data-reply-toggle]').forEach((button) => {
		button.addEventListener('click', () => {
			const comment = button.closest('.comment-body');
			const form = comment?.querySelector('.reply-form');
			if (!form) {
				return;
			}
			form.hidden = !form.hidden;
			if (!form.hidden) {
				form.querySelector('textarea')?.focus();
			}
		});
	});

	if (window.location.hash) {
		const target = document.getElementById(decodeURIComponent(window.location.hash.slice(1)));
		const panel = target?.querySelector('[data-comments-panel]');
		const toggle = target?.querySelector('[data-comments-toggle]');
		if (panel && toggle) {
			panel.hidden = false;
			toggle.classList.add('active');
		}
	}
});
