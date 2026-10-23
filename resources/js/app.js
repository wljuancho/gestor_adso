import './bootstrap';
const hero = document.querySelector('[data-three-hero]');

if (hero) {
    const startThreeAnimation = () => {
        import('three').then((THREE) => {
    const canvasHost = hero.querySelector('[data-three-canvas]');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(50, 1, 0.1, 100);
    camera.position.z = 4.5;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: false, powerPreference: 'low-power' });
    } catch {
        hero.classList.add('three-unavailable');
    }

    if (renderer) {
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.25));
        renderer.setClearColor(0x000000, 0);
        canvasHost.appendChild(renderer.domElement);

        scene.add(new THREE.AmbientLight(0xffffff, 1.1));
        const emeraldLight = new THREE.PointLight(0x10b981, 3.5, 30);
        emeraldLight.position.set(3, 4, 3);
        scene.add(emeraldLight);
        const cyanLight = new THREE.PointLight(0x06b6d4, 3, 30);
        cyanLight.position.set(-3, -2, 2);
        scene.add(cyanLight);

        const badgeGroup = new THREE.Group();
        scene.add(badgeGroup);

        const badge = new THREE.Mesh(
            new THREE.CylinderGeometry(0.82, 0.82, 0.2, 6),
            new THREE.MeshPhongMaterial({
                color: 0x0f172a,
                specular: 0x10b981,
                shininess: 90,
                flatShading: true,
            }),
        );
        badge.rotation.x = Math.PI / 2.8;
        badgeGroup.add(badge);

        const emeraldRing = new THREE.Mesh(
            new THREE.TorusGeometry(1.2, 0.04, 12, 72),
            new THREE.MeshBasicMaterial({ color: 0x10b981 }),
        );
        emeraldRing.rotation.x = Math.PI / 3;
        badgeGroup.add(emeraldRing);

        const cyanRing = new THREE.Mesh(
            new THREE.TorusGeometry(1.43, 0.027, 10, 72),
            new THREE.MeshBasicMaterial({ color: 0x06b6d4, transparent: true, opacity: 0.85 }),
        );
        cyanRing.rotation.y = Math.PI / 4;
        badgeGroup.add(cyanRing);

        const satellite = new THREE.Mesh(
            new THREE.SphereGeometry(0.13, 14, 14),
            new THREE.MeshPhongMaterial({ color: 0x34d399, emissive: 0x10b981, emissiveIntensity: 0.6 }),
        );
        badgeGroup.add(satellite);

        const particleCount = 42;
        const particlePositions = new Float32Array(particleCount * 3);
        for (let i = 0; i < particleCount; i += 1) {
            particlePositions[i * 3] = (Math.random() - 0.5) * 5.2;
            particlePositions[i * 3 + 1] = (Math.random() - 0.5) * 2.8;
            particlePositions[i * 3 + 2] = (Math.random() - 0.5) * 2.4;
        }
        const particleGeometry = new THREE.BufferGeometry();
        particleGeometry.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
        const particles = new THREE.Points(
            particleGeometry,
            new THREE.PointsMaterial({ color: 0x6ee7b7, size: 0.035, transparent: true, opacity: 0.72 }),
        );
        badgeGroup.add(particles);

        let pointerX = 0;
        let pointerY = 0;
        hero.addEventListener('pointermove', (event) => {
            const bounds = hero.getBoundingClientRect();
            pointerX = ((event.clientX - bounds.left) / bounds.width - 0.5) * 0.55;
            pointerY = ((event.clientY - bounds.top) / bounds.height - 0.5) * 0.35;
        });
        hero.addEventListener('pointerleave', () => { pointerX = 0; pointerY = 0; });

        const resizeRenderer = () => {
            const width = Math.max(canvasHost.clientWidth, 1);
            const height = Math.max(canvasHost.clientHeight, 1);
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height, false);
        };
        const resizeObserver = new ResizeObserver(resizeRenderer);
        resizeObserver.observe(canvasHost);
        resizeRenderer();

        let lastFrame = 0;
        const renderFrame = (time) => {
            if (document.hidden || time - lastFrame < 1000 / 30) return;
            lastFrame = time;
            const seconds = time * 0.001;
            badgeGroup.rotation.y = seconds * 0.22 + pointerX;
            badgeGroup.rotation.x = Math.sin(seconds * 0.5) * 0.12 + pointerY;
            emeraldRing.rotation.z = seconds * 0.42;
            cyanRing.rotation.x = Math.PI / 4 + seconds * 0.3;
            satellite.position.set(
                Math.cos(seconds * 1.2) * 1.22,
                Math.sin(seconds * 1.2) * 0.58,
                Math.sin(seconds * 1.2) * 1.22,
            );
            particles.rotation.y = seconds * 0.055;
            renderer.render(scene, camera);
        };

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            lastFrame = Number.NEGATIVE_INFINITY;
            renderFrame(0);
        } else {
            renderer.setAnimationLoop(renderFrame);
        }
    }
        });
    };

    if (typeof window.requestIdleCallback === 'function') {
        window.requestIdleCallback(startThreeAnimation, { timeout: 1600 });
    } else {
        window.setTimeout(startThreeAnimation, 500);
    }
}

const liveSearchForm = document.querySelector('[data-live-search]');

if (liveSearchForm) {
    const searchInput = liveSearchForm.querySelector('input[name="buscar"]');
    const searchPanel = liveSearchForm.closest('.search-panel');
    const feedback = searchPanel.querySelector('[data-search-feedback]');
    let debounceTimer;
    let activeRequest;

    const refreshResults = async () => {
        const term = searchInput.value.trim();
        const url = new URL(liveSearchForm.action, window.location.origin);

        if (term) url.searchParams.set('buscar', term);
        searchPanel.classList.add('is-searching');
        feedback.textContent = 'Buscando aprendices...';
        activeRequest?.abort();
        const requestController = new AbortController();
        activeRequest = requestController;

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                signal: requestController.signal,
            });
            if (!response.ok) throw new Error('No fue posible cargar los resultados.');

            const markup = await response.text();
            const page = new DOMParser().parseFromString(markup, 'text/html');
            const nextList = page.querySelector('.learner-list');
            const currentList = document.querySelector('.learner-list');
            if (!nextList || !currentList) throw new Error('No se encontró el listado de aprendices.');
            currentList.replaceWith(nextList);

            const currentPagination = document.querySelector('.pagination');
            const nextPagination = page.querySelector('.pagination');
            const panel = document.querySelector('.panel');
            if (currentPagination && nextPagination) currentPagination.replaceWith(nextPagination);
            else if (currentPagination) currentPagination.remove();
            else if (nextPagination) panel.append(nextPagination);

            const count = page.querySelector('.result-count')?.textContent ?? '0 resultado(s)';
            document.querySelectorAll('.result-count').forEach((element) => { element.textContent = count; });
            document.querySelectorAll('[data-filtered-total]').forEach((element) => {
                element.textContent = count.match(/\d+/)?.[0] ?? '0';
            });
            feedback.textContent = term ? count : 'Los resultados aparecerán mientras escribes.';

            const clearLink = liveSearchForm.querySelector('.clear-search');
            if (term && !clearLink) {
                const link = document.createElement('a');
                link.className = 'clear-search';
                link.href = liveSearchForm.action;
                link.textContent = 'Limpiar';
                link.setAttribute('aria-label', 'Limpiar búsqueda');
                liveSearchForm.append(link);
            } else if (!term && clearLink) {
                clearLink.remove();
            }

            const nextUrl = term ? `${url.pathname}?${url.searchParams.toString()}` : url.pathname;
            window.history.replaceState({}, '', nextUrl);
        } catch (error) {
            if (error.name !== 'AbortError') feedback.textContent = 'No se pudieron actualizar los resultados. Intenta de nuevo.';
        } finally {
            if (activeRequest === requestController) {
                searchPanel.classList.remove('is-searching');
                activeRequest = null;
            }
        }
    };

    searchInput.addEventListener('input', () => {
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(refreshResults, 300);
    });

    window.addEventListener('popstate', () => {
        const params = new URLSearchParams(window.location.search);
        searchInput.value = params.get('buscar') ?? '';
        refreshResults();
    });
}
