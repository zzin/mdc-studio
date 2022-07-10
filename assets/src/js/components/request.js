import gsap from 'gsap';

const initRequest = () => {
	const formRequest = document.getElementById('formRequest');
	const msgAlert = document.getElementById('msgAlert');
	const inputAgree = document.getElementById('agree');
	const submitButton = formRequest.querySelector('button[type="submit"]');
	const tlSending = gsap.timeline({ repeat: -1, yoyo: true, paused: true });
	const title = document.querySelector('.sending--title');
	if (title) {
		tlSending
			.add('start')
			.set('.sending--title div', { yPercent: 0, autoAlpha: 1 })
			.to('.sending--title div', {
				duration: 0.5,
				yPercent: -101,
				stagger: 0.1,
				ease: 'expt.inout',
				delay: 0.125,
			});
	}

	const chkFormRequired = () => {
		const checkBoxes = document.getElementsByName('scope[]');
		let rtn = false;
		for (let i = 0; i < checkBoxes.length; i++) {
			if (checkBoxes[i].checked === true) {
				rtn = true;
				break;
			}
		}

		for (let i = 0; i < formRequest.elements.length; i++) {
			const target = formRequest.elements[i];
			if (target.value === '' && target.hasAttribute('required')) {
				rtn = false;
				break;
			}
		}

		if (!inputAgree.checked) {
			rtn = false;
		}
		return rtn;
	};

	const aniSending = () => {
		tlSending.play();
	};

	const sendingIn = () => {
		gsap.to('.sending', {
			yPercent: -200,
			duration: 0.65,
			ease: 'power3.out',
			onComplete: () => {
				tlSending.pause();
			},
		});
	};

	submitButton.addEventListener('click', (e) => {
		e.preventDefault();
		const chkForm = chkFormRequired();
		if (chkForm) {
			const data = {
				action: 'saveRequest',
				security: document.getElementById('security').value,
				data: $(formRequest).serialize(),
			};
			$.ajax({
				// eslint-disable-next-line no-undef
				url: frontendAjaxObject.ajaxurl,
				type: 'POST',
				data,
				beforeSend: (xhr) => {
					gsap.set('.sending', { yPercent: 0 });
					gsap.to('.sending', {
						yPercent: -100,
						duration: 0.85,
						ease: 'power4.out',
						onStart: () => {
							tlSending.seek('start');
						},
						onComplete: () => {
							aniSending();
						},
					});
					console.log('beforeSend');
				},
				success: () => {
					window.scrollTo(0, 0);
					formRequest.reset();
					setTimeout(() => {
						sendingIn();
					}, 2600);
				},
				error: (request, status, error) => {
					console.log(
						'code = ' +
							request.status +
							' message = ' +
							request.responseText +
							' error = ' +
							error
					); // 실패 시 처리
				},
			});
		} else {
			msgAlert.classList.remove('hidden');
			setTimeout(() => {
				msgAlert.classList.add('hidden');
			}, 1500);
		}
	});
};
export default initRequest;
