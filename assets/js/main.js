/* YOVANSTRANS — Main JavaScript */
document.addEventListener("DOMContentLoaded", function () {
	// === Navbar Scroll Effect ===
	const navbar = document.querySelector(".navbar");
	if (navbar) {
		window.addEventListener("scroll", function () {
			navbar.classList.toggle("scrolled", window.scrollY > 50);
		});
	}

	// === Mobile Menu ===
	const menuToggle = document.querySelector(".navbar-toggle");
	const mobileMenu = document.querySelector(".mobile-menu");
	const menuOverlay = document.querySelector(".mobile-menu-overlay");
	const menuClose = document.querySelector(".mobile-menu-close");

	function openMenu() {
		mobileMenu && mobileMenu.classList.add("active");
		menuOverlay && menuOverlay.classList.add("active");
		document.body.style.overflow = "hidden";
	}
	function closeMenu() {
		mobileMenu && mobileMenu.classList.remove("active");
		menuOverlay && menuOverlay.classList.remove("active");
		document.body.style.overflow = "";
	}

	menuToggle && menuToggle.addEventListener("click", openMenu);
	menuClose && menuClose.addEventListener("click", closeMenu);
	menuOverlay && menuOverlay.addEventListener("click", closeMenu);

	// === ESC Key — close menus, lightbox, popups ===
	document.addEventListener("keydown", function (e) {
		if (e.key === "Escape" || e.keyCode === 27) {
			closeMenu();
			if (typeof closeLightbox === "function") closeLightbox();
			var popupOvl = document.querySelector(".popup-overlay.active");
			if (popupOvl) popupOvl.classList.remove("active");
			var reviewModal = document.getElementById("reviewModal");
			if (reviewModal && reviewModal.style.display === "flex")
				reviewModal.style.display = "none";
		}
	});

	// === FAQ Accordion ===
	document.querySelectorAll(".faq-question").forEach(function (btn) {
		btn.addEventListener("click", function () {
			const item = this.parentElement;
			const wasActive = item.classList.contains("active");
			// Close all
			document.querySelectorAll(".faq-item").forEach(function (el) {
				el.classList.remove("active");
			});
			if (!wasActive) item.classList.add("active");
		});
	});

	// === Scroll to Top ===
	const scrollTopBtn = document.querySelector(".scroll-top");
	if (scrollTopBtn) {
		window.addEventListener("scroll", function () {
			scrollTopBtn.classList.toggle("visible", window.scrollY > 400);
		});
		scrollTopBtn.addEventListener("click", function () {
			window.scrollTo({ top: 0, behavior: "smooth" });
		});
	}

	// === Animate on Scroll ===
	const animateElements = document.querySelectorAll(".animate-on-scroll");
	if (animateElements.length) {
		const observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add("animated");
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.1 },
		);
		animateElements.forEach(function (el) {
			observer.observe(el);
		});
	}

	// === Popup Promo ===
	const popupOverlay = document.querySelector(".popup-overlay");
	const popupClose = document.querySelector(".popup-close");
	if (popupOverlay) {
		const popupId = popupOverlay.dataset.popupId || "default";
		const freq = popupOverlay.dataset.frequency || "once_per_day";
		const storageKey = "yt_popup_" + popupId;
		let shouldShow = false;
		if (freq === "every_visit") {
			shouldShow = true;
		} else if (freq === "once_per_day") {
			const lastShown = localStorage.getItem(storageKey);
			const today = new Date().toDateString();
			shouldShow = lastShown !== today;
		} else if (freq === "once_only") {
			shouldShow = !localStorage.getItem(storageKey);
		}
		if (shouldShow) {
			setTimeout(function () {
				popupOverlay.classList.add("active");
				if (freq === "once_per_day")
					localStorage.setItem(storageKey, new Date().toDateString());
				if (freq === "once_only") localStorage.setItem(storageKey, "1");
			}, 2000);
		}
	}
	if (popupClose) {
		popupClose.addEventListener("click", function () {
			popupOverlay.classList.remove("active");
		});
	}
	if (popupOverlay) {
		popupOverlay.addEventListener("click", function (e) {
			if (e.target === popupOverlay) popupOverlay.classList.remove("active");
		});
	}

	// === Lightbox ===
	const lightbox = document.querySelector(".lightbox");
	const lightboxImg = lightbox ? lightbox.querySelector("img") : null;
	let lightboxImages = [];
	let lightboxIndex = 0;

	document.querySelectorAll(".gallery-item").forEach(function (item, index) {
		item.addEventListener("click", function () {
			lightboxImages = Array.from(
				document.querySelectorAll(".gallery-item img"),
			);
			lightboxIndex = index;
			openLightbox(lightboxImages[lightboxIndex].src);
		});
	});

	function openLightbox(src) {
		if (!lightbox || !lightboxImg) return;
		lightboxImg.src = src;
		lightbox.classList.add("active");
		document.body.style.overflow = "hidden";
	}
	function closeLightbox() {
		if (!lightbox) return;
		lightbox.classList.remove("active");
		document.body.style.overflow = "";
	}

	const lightboxClose = document.querySelector(".lightbox-close");
	const lightboxPrev = document.querySelector(".lightbox-prev");
	const lightboxNext = document.querySelector(".lightbox-next");

	lightboxClose && lightboxClose.addEventListener("click", closeLightbox);
	lightbox &&
		lightbox.addEventListener("click", function (e) {
			if (e.target === lightbox) closeLightbox();
		});
	lightboxPrev &&
		lightboxPrev.addEventListener("click", function () {
			lightboxIndex =
				(lightboxIndex - 1 + lightboxImages.length) % lightboxImages.length;
			lightboxImg.src = lightboxImages[lightboxIndex].src;
		});
	lightboxNext &&
		lightboxNext.addEventListener("click", function () {
			lightboxIndex = (lightboxIndex + 1) % lightboxImages.length;
			lightboxImg.src = lightboxImages[lightboxIndex].src;
		});

	// === Agent Selector ===
	document.querySelectorAll(".agent-option").forEach(function (opt) {
		opt.addEventListener("click", function () {
			document.querySelectorAll(".agent-option").forEach(function (el) {
				el.classList.remove("selected");
			});
			this.classList.add("selected");
			const waInput = document.getElementById("selected_agent_wa");
			if (waInput) waInput.value = this.dataset.wa;
		});
	});

	// === WhatsApp Booking Form ===
	const bookingForm = document.getElementById("booking-form");
	if (bookingForm) {
		bookingForm.addEventListener("submit", function (e) {
			e.preventDefault();
			const wa = document.getElementById("selected_agent_wa");
			if (!wa || !wa.value) {
				alert("Silakan pilih agen terlebih dahulu!");
				return;
			}
			const data = {
				nama: document.getElementById("f_nama").value,
				rute: document.getElementById("f_rute").value,
				tanggal: document.getElementById("f_tanggal").value,
				jam: document.getElementById("f_jam").value,
				kelas: document.getElementById("f_kelas").value,
				jumlah: document.getElementById("f_jumlah").value,
				jemput: document.getElementById("f_jemput").value,
				catatan: document.getElementById("f_catatan").value,
			};
			let msg = "Halo kak, saya mau pesan tiket:\n";
			msg += "Nama: " + data.nama + "\n";
			msg += "Rute: " + data.rute + "\n";
			msg += "Tanggal: " + data.tanggal + "\n";
			msg += "Jam: " + data.jam + "\n";
			msg += "Kelas: " + data.kelas + "\n";
			msg += "Jumlah penumpang: " + data.jumlah + "\n";
			msg += "Titik jemput: " + data.jemput + "\n";
			msg += "Catatan: " + (data.catatan || "-");
			const url =
				"https://api.whatsapp.com/send?phone=" +
				wa.value +
				"&text=" +
				encodeURIComponent(msg);
			window.open(url, "_blank");
		});
	}

	// === WhatsApp Paket Form ===
	const paketForm = document.getElementById("paket-form");
	if (paketForm) {
		paketForm.addEventListener("submit", function (e) {
			e.preventDefault();
			const wa = document.getElementById("selected_agent_wa");
			if (!wa || !wa.value) {
				alert("Silakan pilih agen terlebih dahulu!");
				return;
			}
			let msg = "Halo kak, saya mau kirim paket:\n";
			msg += "Nama: " + document.getElementById("p_nama").value + "\n";
			msg += "Asal: " + document.getElementById("p_asal").value + "\n";
			msg += "Tujuan: " + document.getElementById("p_tujuan").value + "\n";
			msg += "Jenis Barang: " + document.getElementById("p_jenis").value + "\n";
			msg +=
				"Berat Perkiraan: " + document.getElementById("p_berat").value + "\n";
			msg += "Catatan: " + (document.getElementById("p_catatan").value || "-");
			const url =
				"https://api.whatsapp.com/send?phone=" +
				wa.value +
				"&text=" +
				encodeURIComponent(msg);
			window.open(url, "_blank");
		});
	}

	// === WA Click Tracking ===
	var BASE_URL = document.querySelector('link[href*="style.css"]');
	if (BASE_URL) {
		BASE_URL = BASE_URL.href.split("assets/")[0];
	}
	document.addEventListener("click", function (e) {
		var link = e.target.closest(
			'a[href*="whatsapp.com"], a[href*="wa.me"], .btn-wa, .bottom-bar-wa',
		);
		if (!link) return;
		var href = link.getAttribute("href");
		if (
			!href ||
			(href.indexOf("whatsapp") === -1 && href.indexOf("wa.me") === -1)
		)
			return;

		var waMatch = href.match(/phone=(\d+)/);
		var agentWa = waMatch ? waMatch[1] : "";
		var sourcePage =
			document.title.split("—")[0].trim() || window.location.pathname;

		// Fire-and-forget tracking
		if (BASE_URL) {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", BASE_URL + "api/track-wa", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(
				"source_page=" +
					encodeURIComponent(sourcePage) +
					"&agent_wa=" +
					encodeURIComponent(agentWa) +
					"&route_info=" +
					encodeURIComponent(window.location.pathname),
			);
		}
	});
});
