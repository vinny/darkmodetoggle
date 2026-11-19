/**
 * Dark Mode Toggle Web Component for phpBB 4
 * Based on <dark-mode-toggle> by GoogleChromeLabs.
 * @license © 2019 Google LLC. Licensed under the Apache License, Version 2.0.
 */
(() => {
	'use strict';

	const doc = document;
	let store = {};
	try {
		store = localStorage;
	} catch (err) {
		// Storage unavailable (private browsing / blocked cookies)
	}

	const PREFERS_COLOR_SCHEME = 'prefers-color-scheme';
	const MEDIA = 'media';
	const LIGHT = 'light';
	const DARK = 'dark';
	const MQ_DARK = `(${PREFERS_COLOR_SCHEME}:${DARK})`;
	const MQ_LIGHT = `(${PREFERS_COLOR_SCHEME}:${LIGHT})`;
	const LINK_REL_STYLESHEET = 'link[rel=stylesheet]';
	const REMEMBER = 'remember';
	const LEGEND = 'legend';
	const TOGGLE = 'toggle';
	const SWITCH = 'switch';
	const APPEARANCE = 'appearance';
	const PERMANENT = 'permanent';
	const MODE = 'mode';
	const COLOR_SCHEME_CHANGE = 'colorschemechange';
	const PERMANENT_COLOR_SCHEME = 'permanentcolorscheme';
	const ALL = 'all';
	const NOT_ALL = 'not all';
	const NAME = 'dark-mode-toggle';

	const IMAGES_BASE_URL = new URL(
		'../theme/images/',
		(doc.currentScript && doc.currentScript.src) || location.href
	).href;

	doc.querySelectorAll(`${LINK_REL_STYLESHEET}[href*="dark.css"]`).forEach((link) => {
		link.media = MQ_DARK;
	});

	const reflectString = (target, attr, prop = attr) => {
		Object.defineProperty(target, prop, {
			enumerable: true,
			get() {
				const value = this.getAttribute(attr);
				return value === null ? '' : value;
			},
			set(value) {
				this.setAttribute(attr, value);
			},
		});
	};

	const reflectBoolean = (target, attr, prop = attr) => {
		Object.defineProperty(target, prop, {
			enumerable: true,
			get() {
				return this.hasAttribute(attr);
			},
			set(value) {
				if (value) {
					this.setAttribute(attr, '');
				} else {
					this.removeAttribute(attr);
				}
			},
		});
	};

	const template = doc.createElement('template');
	template.innerHTML = `<style>
*,::after,::before{box-sizing:border-box}
:host{contain:content;display:block}
:host([hidden]){display:none}
form{background-color:var(--${NAME}-background-color,transparent);color:var(--${NAME}-color,inherit);padding:0}
fieldset{border:none;margin:0;padding-block:.25rem;padding-inline:.25rem}
legend{font:var(--${NAME}-legend-font,inherit);padding:0}
input,label{cursor:pointer}
label{white-space:nowrap}
input{opacity:0;position:absolute;pointer-events:none}
input:focus-visible+label{outline:#e59700 auto 2px;outline:-webkit-focus-ring-color auto 5px}
label:not(:empty)::before{margin-inline-end:.5rem}
label::before{content:"";display:inline-block;background-size:var(--${NAME}-icon-size,1rem);background-repeat:no-repeat;height:var(--${NAME}-icon-size,1rem);width:var(--${NAME}-icon-size,1rem);vertical-align:middle}
[part=lightLabel]::before{background-image:var(--${NAME}-light-icon,url("${IMAGES_BASE_URL}sun.svg"))}
[part=darkLabel]::before{filter:var(--${NAME}-icon-filter,none);background-image:var(--${NAME}-dark-icon,url("${IMAGES_BASE_URL}moon.svg"))}
[part=toggleLabel]::before{background-image:var(--${NAME}-checkbox-icon,none)}
[part=permanentLabel]::before{background-image:var(--${NAME}-remember-icon-unchecked,none)}
[part=darkLabel],[part=lightLabel],[part=toggleLabel]{font:var(--${NAME}-label-font,inherit)}
[part=darkLabel]:empty,[part=lightLabel]:empty,[part=toggleLabel]:empty{font-size:0;padding:0}
[part=permanentLabel]{font:var(--${NAME}-remember-font,inherit)}
input:checked+[part=permanentLabel]::before{background-image:var(--${NAME}-remember-icon-checked,none)}
input:checked+[part=darkLabel],input:checked+[part=lightLabel]{background-color:var(--${NAME}-active-mode-background-color,transparent)}
input:checked+[part=darkLabel]::before,input:checked+[part=lightLabel]::before{background-color:var(--${NAME}-active-mode-background-color,transparent)}
input:checked+[part=toggleLabel]::before{filter:var(--${NAME}-icon-filter,none)}
input:checked+[part=toggleLabel]+aside [part=permanentLabel]::before{filter:var(--${NAME}-remember-filter,invert(100%))}
aside{visibility:hidden;margin-block-start:.15rem}
[part=darkLabel]:focus-visible~aside,[part=lightLabel]:focus-visible~aside,[part=toggleLabel]:focus-visible~aside{visibility:visible;transition:visibility 0s}
aside [part=permanentLabel]:empty{display:none}
@media (hover:hover){aside{transition:visibility 3s}aside:hover{visibility:visible}[part=darkLabel]:hover~aside,[part=lightLabel]:hover~aside,[part=toggleLabel]:hover~aside{visibility:visible;transition:visibility 0s}}
</style><form part=form><fieldset part=fieldset><legend part=legend></legend><input part=lightRadio id=l name=mode type=radio><label part=lightLabel for=l></label><input part=darkRadio id=d name=mode type=radio><label part=darkLabel for=d></label><input part=toggleCheckbox id=t type=checkbox><label part=toggleLabel for=t></label><aside part=aside><input part=permanentCheckbox id=p type=checkbox><label part=permanentLabel for=p></label></aside></fieldset></form>`;

	class DarkModeToggle extends HTMLElement {
		static get observedAttributes() {
			return [MODE, APPEARANCE, PERMANENT, LEGEND, LIGHT, DARK, REMEMBER];
		}

		constructor() {
			super();

			reflectString(this, MODE);
			reflectString(this, APPEARANCE);
			reflectString(this, LEGEND);
			reflectString(this, LIGHT);
			reflectString(this, DARK);
			reflectString(this, REMEMBER);
			reflectBoolean(this, PERMANENT);

			this._darkCSS = null;
			this._lightCSS = null;

			doc.addEventListener(COLOR_SCHEME_CHANGE, (event) => {
				this.mode = event.detail.colorScheme;
				this._updateRadios();
				this._updateCheckbox();
			});

			doc.addEventListener(PERMANENT_COLOR_SCHEME, (event) => {
				this.permanent = event.detail.permanent;
				this._permanentCheckbox.checked = this.permanent;
			});

			this._initializeDOM();
		}

		_initializeDOM() {
			const shadowRoot = this.attachShadow({ mode: 'open' });
			shadowRoot.append(template.content.cloneNode(true));

			this._darkCSS = doc.querySelectorAll(`${LINK_REL_STYLESHEET}[${MEDIA}*=${PREFERS_COLOR_SCHEME}][${MEDIA}*="${DARK}"]`);
			this._lightCSS = doc.querySelectorAll(`${LINK_REL_STYLESHEET}[${MEDIA}*=${PREFERS_COLOR_SCHEME}][${MEDIA}*="${LIGHT}"]`);

			this._lightRadio = shadowRoot.querySelector('[part=lightRadio]');
			this._lightLabel = shadowRoot.querySelector('[part=lightLabel]');
			this._darkRadio = shadowRoot.querySelector('[part=darkRadio]');
			this._darkLabel = shadowRoot.querySelector('[part=darkLabel]');
			this._toggleCheckbox = shadowRoot.querySelector('[part=toggleCheckbox]');
			this._toggleLabel = shadowRoot.querySelector('[part=toggleLabel]');
			this._legendLabel = shadowRoot.querySelector('legend');
			this._aside = shadowRoot.querySelector('aside');
			this._permanentCheckbox = shadowRoot.querySelector('[part=permanentCheckbox]');
			this._permanentLabel = shadowRoot.querySelector('[part=permanentLabel]');
		}

		connectedCallback() {
			const hasNativePrefersColorScheme = matchMedia(MQ_DARK).media !== NOT_ALL;

			if (hasNativePrefersColorScheme) {
				matchMedia(MQ_DARK).addEventListener('change', ({ matches }) => {
					if (this.permanent) {
						return;
					}
					this.mode = matches ? DARK : LIGHT;
					this._dispatchEvent(COLOR_SCHEME_CHANGE, { colorScheme: this.mode });
				});
			}

			let rememberedValue = false;
			try {
				rememberedValue = store.getItem(NAME);
			} catch (err) {
				// Ignore storage read errors
			}

			if (rememberedValue && [DARK, LIGHT].includes(rememberedValue)) {
				this.mode = rememberedValue;
				this._permanentCheckbox.checked = true;
				this.permanent = true;
			} else if (hasNativePrefersColorScheme) {
				this.mode = matchMedia(MQ_LIGHT).matches ? LIGHT : DARK;
			}

			if (!this.mode) {
				this.mode = LIGHT;
			}

			if (this.permanent && !rememberedValue) {
				try {
					store.setItem(NAME, this.mode);
				} catch (err) {
					// Ignore storage write errors
				}
			}

			if (!this.appearance) {
				this.appearance = TOGGLE;
			}

			this._updateAppearance();
			this._updateRadios();
			this._updateCheckbox();

			[this._lightRadio, this._darkRadio].forEach((radio) => {
				radio.addEventListener('change', () => {
					this.mode = this._lightRadio.checked ? LIGHT : DARK;
					this._updateCheckbox();
					this._dispatchEvent(COLOR_SCHEME_CHANGE, { colorScheme: this.mode });
				});
			});

			this._toggleCheckbox.addEventListener('change', () => {
				this.mode = this._toggleCheckbox.checked ? DARK : LIGHT;
				this._updateRadios();
				this._dispatchEvent(COLOR_SCHEME_CHANGE, { colorScheme: this.mode });
			});

			this._permanentCheckbox.addEventListener('change', () => {
				this.permanent = this._permanentCheckbox.checked;
				this._dispatchEvent(PERMANENT_COLOR_SCHEME, { permanent: this.permanent });
			});

			this._updateMode();
			this._dispatchEvent(COLOR_SCHEME_CHANGE, { colorScheme: this.mode });
			this._dispatchEvent(PERMANENT_COLOR_SCHEME, { permanent: this.permanent });
		}

		attributeChangedCallback(name, oldValue, newValue) {
			if (name === MODE) {
				if (![LIGHT, DARK].includes(newValue)) {
					throw new RangeError(`Allowed values: "${LIGHT}" and "${DARK}".`);
				}
				if (matchMedia('(hover:none)').matches && this.remember) {
					this._showPermanentAside();
				}
				if (this.permanent) {
					try {
						store.setItem(NAME, this.mode);
					} catch (err) {
						// Ignore storage write errors
					}
				}
				this._updateRadios();
				this._updateCheckbox();
				this._updateMode();
			} else if (name === APPEARANCE) {
				if (![TOGGLE, SWITCH].includes(newValue)) {
					throw new RangeError(`Allowed values: "${TOGGLE}" and "${SWITCH}".`);
				}
				this._updateAppearance();
			} else if (name === PERMANENT) {
				if (this.permanent) {
					if (this.mode) {
						try {
							store.setItem(NAME, this.mode);
						} catch (err) {
							// Ignore storage write errors
						}
					}
				} else {
					try {
						store.removeItem(NAME);
					} catch (err) {
						// Ignore storage removal errors
					}
				}
				this._permanentCheckbox.checked = this.permanent;
			} else if (name === LEGEND) {
				this._legendLabel.textContent = newValue;
			} else if (name === REMEMBER) {
				this._permanentLabel.textContent = newValue;
			} else if (name === LIGHT) {
				this._lightLabel.textContent = newValue;
				if (this.mode === LIGHT) {
					this._toggleLabel.textContent = newValue;
				}
			} else if (name === DARK) {
				this._darkLabel.textContent = newValue;
				if (this.mode === DARK) {
					this._toggleLabel.textContent = newValue;
				}
			}
		}

		_dispatchEvent(type, detail) {
			this.dispatchEvent(new CustomEvent(type, {
				bubbles: true,
				composed: true,
				detail,
			}));
		}

		_updateAppearance() {
			const isToggle = this.appearance === TOGGLE;
			this._lightRadio.hidden = isToggle;
			this._lightLabel.hidden = isToggle;
			this._darkRadio.hidden = isToggle;
			this._darkLabel.hidden = isToggle;
			this._toggleCheckbox.hidden = !isToggle;
			this._toggleLabel.hidden = !isToggle;
		}

		_updateRadios() {
			if (this.mode === LIGHT) {
				this._lightRadio.checked = true;
			} else {
				this._darkRadio.checked = true;
			}
		}

		_updateCheckbox() {
			if (this.mode === LIGHT) {
				this._toggleLabel.style.setProperty(
					`--${NAME}-checkbox-icon`,
					`var(--${NAME}-light-icon,url("${IMAGES_BASE_URL}moon.svg"))`
				);
				this._toggleLabel.textContent = this.light;
				const ariaText = this.light || this.dataset.labelDark || DARK;
				this._toggleCheckbox.setAttribute('aria-label', ariaText);
				this._toggleLabel.setAttribute('aria-label', ariaText);
				this._toggleCheckbox.checked = false;
			} else {
				this._toggleLabel.style.setProperty(
					`--${NAME}-checkbox-icon`,
					`var(--${NAME}-dark-icon,url("${IMAGES_BASE_URL}sun.svg"))`
				);
				this._toggleLabel.textContent = this.dark;
				const ariaText = this.dark || this.dataset.labelLight || LIGHT;
				this._toggleCheckbox.setAttribute('aria-label', ariaText);
				this._toggleLabel.setAttribute('aria-label', ariaText);
				this._toggleCheckbox.checked = true;
			}
		}

		_updateMode() {
			doc.documentElement.dataset.colorScheme = this.mode;

			if (this.mode === LIGHT) {
				this._lightCSS.forEach((link) => {
					link.media = ALL;
					link.disabled = false;
				});
				this._darkCSS.forEach((link) => {
					link.media = NOT_ALL;
					link.disabled = true;
				});
			} else {
				this._darkCSS.forEach((link) => {
					link.media = ALL;
					link.disabled = false;
				});
				this._lightCSS.forEach((link) => {
					link.media = NOT_ALL;
					link.disabled = true;
				});
			}
		}

		_showPermanentAside() {
			this._aside.style.visibility = 'visible';
			setTimeout(() => {
				this._aside.style.visibility = 'hidden';
			}, 3000);
		}
	}

	if (!customElements.get(NAME)) {
		customElements.define(NAME, DarkModeToggle);
	}
})();
